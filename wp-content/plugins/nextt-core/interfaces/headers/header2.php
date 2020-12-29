<div class="static-menu">
    <div class="container">
        <div class="row">

            <div class="col-md-12 menu_container">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->

                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="<?=get_site_url()?>" class="navbar-brand" id="static-menu-logo">
                                <img src="<?=get_stylesheet_directory_uri().'/images/logo.png'?>">
                            </a>
                        </div>

                        <?php wp_nav_menu( array(
                                'menu'              => 'header-menu',
                                'theme_location'    => 'header-menu',
                                'depth'             => 2,
                                'container'         => 'div',
                                'container_class'   => 'collapse navbar-collapse',
                                'container_id'      => 'bs-example-navbar-collapse-1',
                                'menu_class'        => 'nav navbar-nav',
                                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                                'walker'            => new Responsive_Menu())
                        );?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
