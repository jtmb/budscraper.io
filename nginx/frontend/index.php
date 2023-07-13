<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=0.8" />
  <link rel="stylesheet" type="text/css" href="style/style.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>BudScraper.io | Search Any Strain, get the lowest, closest prices. </title>
</head>
<script>
  window.addEventListener('DOMContentLoaded', function () {
    var searchForm = document.getElementById('searchForm');
    searchForm.addEventListener('submit', function (event) {
      var searchInput = document.getElementById('searchInput');
      if (searchInput.value.trim() === '') {
        event.preventDefault();
        alert('Please enter a search query.');
      }
    });
  });
</script>
<body>
  <div class="star-field">
    <div class="layer"></div>
    <div class="layer"></div>
    <div class="layer"></div>
  </div>
  <div class="container">
    <div class="card">
      <h3>BudScraper.io</h3>
      <div class="drop_box">
        <header>
          <h4>Find Your Bud</h4>
        </header>
        <p>Search Any Strain, get the lowest, closest prices.</p>
        <form class="example" action="action_page.php" method="get" onsubmit="openPopup(event)">
          <input type="text" placeholder="Search.." name="search">
          <button type="submit"><i class="fa fa-search"></i></button>
        </form>
      </div>
    </div>
  </div>
</body>
