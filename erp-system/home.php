<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Professional Homepage</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg " style="background-color: #10181f; color: white;">

    <a class="navbar-brand" href="#">BrandName</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </nav>

  <header class="header">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1>Welcome to Our Professional Homepage</h1>
          <p>Your success is our commitment</p>
          
        </div>
        
      </div>
    </div>
  </header>

  <section class="services">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
             <div class="card-body">
              <h5 class="card-title">Customer Manegment</h5>
              <p class="card-text">Description of service 1.</p>
              <a href="customer.php" class="btn btn-primary">Customer</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Item Manegment</h5>
              <p class="card-text">Description of service 2.</p>
              <a href="item.php" class="btn btn-primary">Item</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">All Reports</h5>
              <p class="card-text">Description of service 3.</p>
              <a href="reports.php" class="btn btn-primary">Reports</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  

  

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="scripts.js"></script>
</body>


</html>


