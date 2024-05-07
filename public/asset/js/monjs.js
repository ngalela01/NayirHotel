document.getElementById('customRange1').addEventListener('input', function() {
    var price = document.getElementById('customRange1').value;
    document.getElementById('priceOutput').textContent = '€' + price;
});
