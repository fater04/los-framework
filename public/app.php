<?php
use app\DefaultApp\DefaultApp as app;
try {
//inclure autoload
    require "../vendor/autoload.php";
////inclure la configuration
    require "../app/DefaultApp/configuration.php";

////instancier une nouvelle application
    new \app\DefaultApp\DefaultApp($configuration);
////inclure les diferents route definit dans app/Routing.php
    \app\DefaultApp\DefaultApp::routing();
////on demarre l'application
    \app\DefaultApp\DefaultApp::run();
}Catch(Exception $exception) {

?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>B-EVENT ~ <?php if (isset($titre)) echo $titre ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="<?php echo app::autre("plugins/switchery/switchery.min.css") ?>" rel="stylesheet">
        <link href="<?php echo app::autre("plugins/jquery-circliful/css/jquery.circliful.css") ?>" rel="stylesheet">
        <link href="<?php echo app::css("bootstrap.min") ?>" rel="stylesheet">
        <link href="<?php echo app::css("icons") ?>" rel="stylesheet">
        <link href="<?php echo app::css("style") ?>" rel="stylesheet">
        <script src="<?php echo app::js("modernizr.min") ?>"></script>

    </head>
    <body>

    <div class="ex-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <svg class="svg-box" width="380px" height="500px" viewBox="0 0 837 1045" version="1.1"
                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" >
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                           sketch:type="MSPage">
                            <path d="M353,9 L626.664028,170 L626.664028,487 L353,642 L79.3359724,487 L79.3359724,170 L353,9 Z"
                                  id="Polygon-1" stroke="#3bafda" stroke-width="6" sketch:type="MSShapeGroup"></path>
                            <path d="M78.5,529 L147,569.186414 L147,648.311216 L78.5,687 L10,648.311216 L10,569.186414 L78.5,529 Z"
                                  id="Polygon-2" stroke="#7266ba" stroke-width="6" sketch:type="MSShapeGroup"></path>
                            <path d="M773,186 L827,217.538705 L827,279.636651 L773,310 L719,279.636651 L719,217.538705 L773,186 Z"
                                  id="Polygon-3" stroke="#f76397" stroke-width="6" sketch:type="MSShapeGroup"></path>
                            <path d="M639,529 L773,607.846761 L773,763.091627 L639,839 L505,763.091627 L505,607.846761 L639,529 Z"
                                  id="Polygon-4" stroke="#00b19d" stroke-width="6" sketch:type="MSShapeGroup"></path>
                            <path d="M281,801 L383,861.025276 L383,979.21169 L281,1037 L179,979.21169 L179,861.025276 L281,801 Z"
                                  id="Polygon-5" stroke="#ffaa00" stroke-width="6" sketch:type="MSShapeGroup"></path>
                        </g>
                    </svg>
                </div>

                <div class="col-lg-6">
                    <div class="message-box">
                        <h1 class="m-b-0">404</h1>
                        <h4>Page not found</h4>
                        <div class="buttons-con">
                            <div class="action-link-wrap">
                                <a onclick="history.back(-1)" href="#" class="btn btn-custom btn-primary waves-effect waves-light m-t-20">Go Back</a>
                                <a href="<?= \app\DefaultApp\DefaultApp::genererUrl("Home") ?>" class="btn btn-custom btn-primary waves-effect waves-light m-t-20">Go to Home Page</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        var resizefunc = [];
    </script>

    <script src="<?php echo app::js("jquery.min") ?>"></script>
    <script src="<?php echo app::js("popper.min") ?>"></script>
    <script src="<?php echo app::js("bootstrap.min") ?>"></script>
    <script src="<?php echo app::js("detect") ?>"></script>
    <script src="<?php echo app::js("fastclick") ?>"></script>
    <script src="<?php echo app::js("jquery.slimscroll") ?>"></script>
    <script src="<?php echo app::js("jquery.blockUI") ?>"></script>
    <script src="<?php echo app::js("waves") ?>"></script>
    <script src="<?php echo app::js("wow.min") ?>"></script>
    <script src="<?php echo app::js("jquery.nicescroll") ?>"></script>
    <script src="<?php echo app::js("jquery.scrollTo.min") ?>"></script>
    <script src="<?php echo app::autre("plugins/switchery/switchery.min.js") ?>"></script>
    <script src="<?php echo app::js("jquery.core") ?>"></script>
    <script src="<?php echo app::js("jquery.app") ?>"></script>

    </body>
    </html>
<?php
}