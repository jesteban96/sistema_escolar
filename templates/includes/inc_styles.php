

<!-- Todo plugin debe ir debajo de está línea -->
<!-- Toastr css -->

<!-- Waitme css -->
<link rel="stylesheet" href="<?php echo PLUGINS.'waitme/waitMe.min.css'; ?>">

<!-- Lightbox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css"/>

<!-- Estilos en header deben ir debajo de esta línea -->
<!--<style>
  .btn {
    border-radius: 5px;
  }

  .bg-gradient {
    background: rgba(38, 38, 38, 1);
    background: -moz-linear-gradient(left, rgba(38, 38, 38, 1) 0%, rgba(28, 33, 28, 1) 100%);
    background: -webkit-gradient(left top, right top, color-stop(0%, rgba(38, 38, 38, 1)), color-stop(100%, rgba(28, 33, 28, 1)));
    background: -webkit-linear-gradient(left, rgba(38, 38, 38, 1) 0%, rgba(28, 33, 28, 1) 100%);
    background: -o-linear-gradient(left, rgba(38, 38, 38, 1) 0%, rgba(28, 33, 28, 1) 100%);
    background: -ms-linear-gradient(left, rgba(38, 38, 38, 1) 0%, rgba(28, 33, 28, 1) 100%);
    background: linear-gradient(to right, rgba(38, 38, 38, 1) 0%, rgba(28, 33, 28, 1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#262626', endColorstr='#1c211c', GradientType=1);
  }

  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }
</style>-->

<!-- Estilos SB Admin 2 -->
<link href=" <?php echo ASSETS.'vendor/fontawesome-free/css/all.min.css'; ?> " rel="stylesheet" type="text/css">
<link
  href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
  rel="stylesheet"
>
<!-- Custom styles for this template-->
<link href="<?php echo CSS.'sb-admin-2.min.css'; ?>" rel="stylesheet">

<!-- Estilos de pluging -->
<link href="<?php echo ASSETS.'vendor/datatables/dataTables.bootstrap4.min.css"'?>  rel="stylesheet ">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


<!-- Estilos registrados manualmente -->
<?php echo load_styles(); ?>

<!-- Estilos personalizados deben ir en main.css o abajo de esta línea -->
<link rel="stylesheet" href="<?php echo CSS.'main.css?v='.get_version(); ?>">
