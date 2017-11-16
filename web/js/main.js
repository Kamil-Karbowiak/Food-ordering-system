$(document).ready(function(){
    $("#quantityUp").click(function(){
        var quantity = $("#mealQuantity").val();
        $("#mealQuantity").val(++quantity);
        var price = $("#totalCost").data("price");
        var total = quantity * price;
        $("#totalCost").html("<strong>Total: </strong>"+total.toFixed(2)+" &euro;");
    });
    $("#quantityDown").click(function(){
        var quantity = $("#mealQuantity").val();
        if(quantity > 0){
            $("#mealQuantity").val(--quantity);
        }
        var price = $("#totalCost").data("price");
        var total = quantity * price;
        $("#totalCost").html("<strong>Total: </strong>"+total.toFixed(2)+" &euro;");
    });
});