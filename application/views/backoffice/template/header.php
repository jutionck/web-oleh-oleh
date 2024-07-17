<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>
  <link href="<?= base_url('assets') ?>/images/favicon.png" rel="icon">
  <link href="<?= base_url('assets') ?>/images/favicon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="<?= base_url('assets/backoffice') ?>/css/styles.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/backoffice') ?>/css/custom.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="<?= base_url('assets/official') ?>/css/select2.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .select2-container--default .select2-selection--single {
      border: 1px solid #ced4da;
      border-radius: 0.375rem;
      height: calc(1.5em + 0.75rem + 2px);
      padding: 0.375rem 0.75rem;
      font-size: 1rem;
      line-height: 1.5;
    }
  </style>
  <style>
    div.dataTables_filter {
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">