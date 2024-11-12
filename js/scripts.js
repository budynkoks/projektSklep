$(document).ready(function() {
    $('#wishlistHeart').on("click",function() {
        var productId = $(this).data('product-id'); 

        $.post('add_to_wishlist.php', { product_id: productId }, function(response) {
            if (response.trim() === "Added to wishlist!") {
                $('#wishlistHeart').attr('src', 'images/icons8-heart-30red.png');
            } else if (response.trim() === "Item removed from wishlist!") {
                $('#wishlistHeart').attr('src', 'images/icons8-heart-50.png'); 
            }
        }, 'text')
        .fail(function() {
            alert("Wystąpił błąd podczas dodawania do ulubionych.");
        });
    });
   
   
    $(".thumbnail").on("click", function() {
        const newSrc = $(this).attr("src");
        $("#mainImage").attr("src", newSrc);
    });
    $(".thumbnail").on("click", function() {
        const newSrc = $(this).attr("src");
        $("#mainImage").attr("src", newSrc);
    });

    
    $("#mainImageLink").on("click", function() {
        const src = $("#mainImage").attr("src");
        $("#lightboxImage").attr("src", src);
        $("#lightbox").fadeIn();
    });

   
    $(".close").on("click", function() {
        $("#lightbox").fadeOut();
    });
    $('#contactForm').on('submit', function(event) {
        const userId = $('input[name="idUser"]').val();
        if (!userId) {
            event.preventDefault();
            alert("Proszę się zalogować.");
            window.location.href = "login.php";
        }
    });

    
   
   
});
