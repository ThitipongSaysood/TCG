<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

class BuildStatic extends Command
{
    protected $signature = 'static:build {--out=docs : Output directory relative to project root}';
    protected $description = 'Render all Blade pages to static HTML for GitHub Pages';

    /** route name → static file name */
    private array $files = [
        'home'             => 'index.html',
        'products.index'   => 'products.html',
        'products.show'    => 'product-detail.html',
        'cart.index'       => 'cart.html',
        'checkout.index'   => 'checkout.html',
        'auctions.index'   => 'auction-list.html',
        'auctions.show'    => 'auction-detail.html',
        'live.index'       => 'live-queue.html',
        'collection.index' => 'my-collection.html',
        'orders.index'     => 'my-orders.html',
        'psa.index'        => 'psa-submission.html',
        'tracking.show'    => 'tracking.html',
        'profile.show'     => 'profile.html',
        'login'            => 'login.html',
        'register'         => 'register.html',
    ];

    /** route name → blade view name */
    private array $views = [
        'home'             => 'home',
        'products.index'   => 'products.index',
        'products.show'    => 'products.show',
        'cart.index'       => 'cart.index',
        'checkout.index'   => 'checkout.index',
        'auctions.index'   => 'auctions.index',
        'auctions.show'    => 'auctions.show',
        'live.index'       => 'live.index',
        'collection.index' => 'collection.index',
        'orders.index'     => 'orders.index',
        'psa.index'        => 'psa.index',
        'tracking.show'    => 'tracking.show',
        'profile.show'     => 'profile.show',
        'login'            => 'auth.login',
        'register'         => 'auth.register',
    ];

    private array $idRoutes = ['products.show', 'auctions.show', 'tracking.show'];

    public function handle(Filesystem $fs): int
    {
        $out = base_path($this->option('out'));
        $fs->ensureDirectoryExists($out);

        // ShareErrorsFromSession is web-only — provide an empty bag for CLI rendering
        View::share('errors', new ViewErrorBag);

        // Render the mockup as a logged-in demo user so navbar/drawer show the
        // avatar chip + tier instead of the "เข้าสู่ระบบ" button. The user is
        // not persisted — just held in the guard for the duration of the build.
        $demo = (new User)->forceFill([
            'id'              => 1,
            'display_name'    => 'PANYA',
            'email'           => 'demo@cardzone.local',
            'membership_tier' => 'gold',
        ]);
        Auth::setUser($demo);

        // Build URL → file replacement table (longer first to avoid partial matches)
        $replacements = [];
        foreach ($this->files as $name => $file) {
            $params = in_array($name, $this->idRoutes) ? ['id' => 1] : [];
            $url = route($name, $params); // absolute
            $replacements[$url] = $file;
        }
        uksort($replacements, fn ($a, $b) => strlen($b) - strlen($a));

        // Asset host prefix to strip (turns http://host/assets/... into assets/...)
        $assetHost = rtrim(url(''), '/') . '/';

        foreach ($this->views as $name => $view) {
            $data = ['active' => $name];
            if (in_array($name, $this->idRoutes)) $data['id'] = 1;

            $html = view($view, $data)->render();

            // Replace route URLs with .html targets — match inside href/action
            // attributes only, so substrings (like host inside an asset URL)
            // aren't mangled
            foreach ($replacements as $url => $file) {
                foreach (['href', 'action'] as $attr) {
                    $html = str_replace($attr . '="' . $url . '"', $attr . '="' . $file . '"', $html);
                    $html = str_replace($attr . "='" . $url . "'", $attr . "='" . $file . "'", $html);
                }
            }

            // Strip host from any remaining absolute URLs (e.g. asset()) →
            // relative paths so the site works from /TCG/ on GitHub Pages
            $html = str_replace($assetHost, '', $html);

            // Drop POST logout form — Pages can't handle POST
            $html = preg_replace(
                '/<form[^>]*action="[^"]*logout[^"]*"[^>]*>.*?<\/form>/s',
                '',
                $html
            );

            $target = $out . '/' . $this->files[$name];
            file_put_contents($target, $html);
            $this->line('  ✓ ' . $this->files[$name]);
        }

        // Copy public/assets → docs/assets so relative refs resolve
        $assetsSrc = public_path('assets');
        $assetsDest = $out . '/assets';
        if ($fs->isDirectory($assetsDest)) $fs->deleteDirectory($assetsDest);
        $fs->copyDirectory($assetsSrc, $assetsDest);
        $this->line('  ✓ assets/');

        // Add .nojekyll so GitHub Pages serves all files as-is
        file_put_contents($out . '/.nojekyll', '');

        $this->info('Built ' . count($this->views) . " pages to {$this->option('out')}/");
        return self::SUCCESS;
    }
}
