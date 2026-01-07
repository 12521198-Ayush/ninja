<?php
namespace App\Addons\EmbeddedSignup;
use App\AddonManager\Addon;

class EmbeddedSignupAddon extends Addon
{
    public $name                 = 'EmbeddedSignup';

    public $description          = 'Embedded Signup Addon';

    public $version              = '1.2.0';

    public $author               = 'SpaGreen Creative';

    public $author_url           = 'https://codecanyon.net/user/spagreen/portfolio';

    public $tag                  = 'EmbeddedSignup, Addon, Demo';

    public $addon_identifier     = 'embedded_signup';

    public $required_cms_version = '2.3.0';

    public $required_app_version = '2.3.0';

    public $license              = 'General Public License';

    public $license_url          = 'https://mit-license.org/GPL';

    public function boot()
    {
        $this->enableViews();
        $this->enableRoutes();
    }

    public function addonActivated()
    {
        dd('I am activated');
    }

    public function addonDeactivated()
    {
        dd('I am deActivated');
    }

}
