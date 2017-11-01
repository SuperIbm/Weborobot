<!DOCTYPE html>

<html lang="ru">

<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=yes" />

    <base href="{$DOMAIN_NAME}" />

    <meta name="keywords" content="{$KEYWORDS}" />
    <meta name="description" content="{$DESCRIPTION}" />

    <link rel="stylesheet" type="text/css" href="css/main.css">

    <script type="text/javascript" src="bower_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="bower_modules/semantic/dist/components/sidebar.js"></script>

    <script type="text/javascript" src="js/weborobot.js"></script>
    <script type="text/javascript" src="js/site.js"></script>

    <title>{$TITLE}</title>

</head>

<body>

<div class="ui sidebar vertical inverted menu">
    <a class="active item">Home</a>
    <a class="item">Work</a>
    <a class="item">Company</a>
    <a class="item">Careers</a>
    <a class="item">Login</a>
    <a class="item">Signup</a>
</div>

<div class="pusher">
    <div class="ui inverted vertical masthead center aligned segment">
        <div class="ui inverted pointing menu large">
            <div class="ui container">
                <div class="item">
                    <a class="toc item toggleMenu">
                        <i class="sidebar icon"></i>
                    </a>
                </div>
                <a href="" class="header item">
                    <img class="logo" src="storage/app/public/uploads/images/logo.png">
                    My Own Site
                </a>
                <div class="ui simple dropdown item">
                    Dropdown <i class="dropdown icon"></i>
                    <div class="ui massive vertical menu">
                        <div class="item addition forSearch">
                            <div class="ui icon input">
                                <input type="text" placeholder="Поиск по сайту...">
                                <i class="search icon"></i>
                            </div>
                        </div>
                        <div class="divider addition forSearch"></div>

                        <a class="item" href="#">О компании</a>
                        <a class="item" href="#">Каталог</a>
                        <div class="item">
                            <i class="dropdown icon"></i>
                            История
                            <div class="menu">
                                <a class="item" href="#">2016</a>
                                <a class="item" href="#">2015</a>
                            </div>
                        </div>
                        <a class="item" href="#">Контактная информация</a>

                        <div class="divider addition"></div>
                        <a class="item addition">
                            <i class="sign in layout icon"></i> Войти
                        </a>
                        <a class="item addition">
                            <i class="add user layout icon"></i> Регистрация
                        </a>
                    </div>
                </div>
                <div class="right menu sideMenu">
                    <div class="item formSearch">
                        <div class="ui transparent inverted icon input">
                            <input type="text" placeholder="Поиск по сайту...">
                            <i class="search link icon"></i>
                        </div>
                    </div>
                    <div class="item">
                        <a class="ui inverted button">Войти</a>
                    </div>
                    <div class="item">
                        <a class="ui inverted button">Регистрация</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui inverted divider"></div>

        <div class="ui text container">
            <h1 class="ui inverted header">
                Здесь будет ваш слоган
            </h1>
            <h2>Скажи или сделай здесь все что пожелаешь.</h2>
            <div class="ui huge primary button">Давай начнем <i class="right arrow icon"></i></div>
        </div>
    </div>

    <div class="ui main container">
        <div class="ui grid">
            <div class="wide column CONTENT">
                {$CONTENT}
            </div>
        </div>
    </div>

    <div class="ui inverted vertical footer segment">
        <div class="ui left aligned container">
            <div class="ui stackable inverted divided grid">
                <div class="three wide column">
                    <h4 class="ui inverted header">Group 1</h4>
                    <div class="ui inverted link list">
                        <a href="#" class="item">Link One</a>
                        <a href="#" class="item">Link Two</a>
                        <a href="#" class="item">Link Three</a>
                        <a href="#" class="item">Link Four</a>
                    </div>
                </div>
                <div class="three wide column">
                    <h4 class="ui inverted header">Group 2</h4>
                    <div class="ui inverted link list">
                        <a href="#" class="item">Link One</a>
                        <a href="#" class="item">Link Two</a>
                        <a href="#" class="item">Link Three</a>
                        <a href="#" class="item">Link Four</a>
                    </div>
                </div>
                <div class="three wide column">
                    <h4 class="ui inverted header">Group 3</h4>
                    <div class="ui inverted link list">
                        <a href="#" class="item">Link One</a>
                        <a href="#" class="item">Link Two</a>
                        <a href="#" class="item">Link Three</a>
                        <a href="#" class="item">Link Four</a>
                    </div>
                </div>
                <div class="seven wide column">
                    <h4 class="ui inverted header">Footer Header</h4>
                    <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
                </div>
            </div>

            <div class="ui inverted section divider"></div>

            <a href="" class="header item">
                <img src="storage/app/public/uploads/images/logo.png" class="ui centered mini image">
            </a>

            <div class="ui horizontal inverted small divided link list">
                <a class="item" href="#">Site Map</a>
                <a class="item" href="#">Contact Us</a>
                <a class="item" href="#">Terms and Conditions</a>
                <a class="item" href="#">Privacy Policy</a>
            </div>
        </div>
    </div>
</div>

</body>

</html>