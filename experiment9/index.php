<?php ?>
<!DOCTYPE html>
<html>
<head>
    <title>TechStore</title>

    <style>
        body { font-family: Arial; background:#f5f5f5; }
        h1 { text-align:center; }

        .grid {
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
            gap:20px;
            padding:20px;
        }

        .card {
            background:white;
            padding:15px;
            border-radius:10px;
            text-align:center;
        }

        img {
            width:100%;
            height:150px;
            object-fit:cover;
        }
    </style>
</head>

<body>

<h1>🛒 TechStore</h1>

<div class="grid" id="products"></div>

<script>
fetch('get_products.php')
.then(res => res.json())
.then(data => {

    let html = "";

    data.forEach(p => {
        html += `
        <div class="card">
            <img src="images/${p.image}">
            <h3>${p.name}</h3>
            <p>${p.description}</p>
            <p><b>₹${p.price}</b></p>
        </div>`;
    });

    document.getElementById("products").innerHTML = html;
});
</script>

</body>
</html>