<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logo Example</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }
    .logo-container {
      background: #f8f8f8;
      padding: 15px;
      text-align: center;
      border-bottom: 0px solid #ddd;
    }
    .logo-container img {
      max-width: 300px; /* control logo size */
      height: auto;
    }
  </style>
</head>
<body>

  <!-- Logo Holder -->
  <div class="logo-container">
    <img src="assets/images/leologo.jpg" alt="Company Logo">
  </div>

</body>
</html>

<div class="side-menu animate-dropdown outer-bottom-xs">
    <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>        
    <nav class="yamm megamenu-horizontal" role="navigation">
  
        <ul class="nav">
            <li class="dropdown menu-item">
              <?php $sql=mysqli_query($con,"select id,categoryName  from category");
while($row=mysqli_fetch_array($sql))
{
    ?>
                <a href="category.php?cid=<?php echo $row['id'];?>" class="dropdown-toggle"><i class="icon fa fa-desktop fa-fw"></i>
                <?php echo $row['categoryName'];?></a>
                <?php }?>
                        
</li>
</ul>
    </nav>
</div>
