<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nordic Gallery">
    <title>Grima - Contact</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/c312d72489.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="my-container">
        <div>
            <div class="my-row pt-4">
                <div class="my-col-left">
                    <div class="my-site-header media">
                        <i class="fa-solid fa-mountain fa-3x mt-1 my-logo"></i>
                        <div class="media-body">
                            <h1 class="my-sitename text-uppercase">Grima</h1>
                            <p class="my-slogon">Scandinavian nature</p>
                        </div>
                    </div>
                </div>
                <div class="my-col-right">
                    <nav class="navbar navbar-expand-lg" id="my-main-nav">
                        <button class="navbar-toggler toggler-example mr-0 ml-auto" type="button"
                            data-toggle="collapse" data-target="#navbar-nav"
                            aria-controls="navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
                            <span><i class="fas fa-bars"></i></span>
                        </button>
                        <div class="collapse navbar-collapse my-nav" id="navbar-nav">
                            <ul class="navbar-nav text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link my-nav-link" href="index.html">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link my-nav-link" href="about.html">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link my-nav-link" href="records.html">Records</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link my-nav-link" href="photos.html">Photos</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link my-nav-link" href="contact.php">Contact <span class="sr-only">(current)</span></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="my-row">
                <div class="my-col-left"></div>
                <main class="my-col-right my-contact-main"> <!-- Content -->
                    <section class="my-content my-contact">
                        <h2 class="mb-4 my-content-title">Contact Us</h2>
                        <p class="mb-85">If you would like to share some stunning Scandinavian nature photos with us, feel free to contact us.</p>
                        <form id="contact-form" method=post>
                            <div class="form-group mb-4">
                                <input type="text" name="name" class="form-control" placeholder="Name" />
                            </div>
                            <div class="form-group mb-4">
                                <input type="email" name="email" class="form-control" placeholder="Email" />
                            </div>
                            <div class="form-group mb-5">
                                <textarea rows="6" name="message" id = "message" class="form-control"
                                          placeholder="Message..." required=""></textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-big btn-primary">Send</button>
                            </div>
                        </form>
                        <div class = "mt-5">
                            <?php include 'script.php' ?>
                        </div>
                    </section>
                </main>
            </div>
        </div>

        <div class="my-row">
            <div class="my-col-left text-center">
                <ul class="my-bg-controls-wrapper">
                    <li class="my-bg-control active" data-id="0"></li>
                    <li class="my-bg-control" data-id="1"></li>
                    <li class="my-bg-control" data-id="2"></li>
                </ul>
            </div>
            <div class="my-col-right my-col-footer">
                <footer class="my-site-footer text-right">
                    <p class="mb-0">Copyright: Denis Shpitalenkov, 251002</p>
                </footer>
            </div>
        </div>

        <!-- Diagonal background design -->
        <div class="my-bg">
            <div class="my-bg-left"></div>
            <div class="my-bg-right"></div>
        </div>
    </div>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.backstretch.min.js"></script>
    <script src="js/slideshow.js"></script>
</body>
</html>