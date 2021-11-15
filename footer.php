<!DOCTYPE html>
<html lang="en">
<head>
  <title>Header</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" type="text/css" href="style.css">
  <!-- load your styles --> 
</head>
<style type="text/css">
  #footer2
{
  flex-wrap: wrap;
  padding-right: 3%;
}

#footer1
{
  padding-left: 3%;
} 

footer
{
  display: flex;
  justify-content: space-between;
  clear: both;
  text-align: center;
  font-size: 1em;
  align-items: center;
  margin-left: auto;
  margin-right: auto;
  padding-top: 1%;
  padding-bottom: 10px;
  background: #C9D6FF;  /* fallback for old browsers */
  background: -webkit-linear-gradient(to right, #E2E2E2, #C9D6FF);  /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(to right, #E2E2E2, #C9D6FF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}

#footer2 li
{
  display: inline-flex;
  flex-wrap: wrap;
  list-style: none;
  padding: 7px 7px;
}

footer ul li a
{
  text-decoration: none;
  color: #0000ff;
}

footer li a:hover, footer li a:focus
{
  color: #ffa500;
  text-decoration: none;
}
</style>
<body>
  <footer>
    <p id="footer1"> Since 2020 - Green Bean Shop</p> 
    <ul id="footer2">
        <li><a href="index.php">Home</a></li>
        <li><a href="product.php">Products</a></li>
        <li><a href="about_us.php">About Us</a></li>                     
    </ul>                
  </footer>
</body>