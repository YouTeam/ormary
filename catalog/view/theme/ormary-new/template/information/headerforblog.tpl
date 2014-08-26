<style>
    
    .uv-icon.uv-bottom-right {
    display: none;
    }
    
    </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>

$(document).ready( function () {
    $('header a').each ( function () {
        var _this = $(this);
        _this.attr('target' , '_top')
    }) 

})

</script>
<?php echo $header; ?>