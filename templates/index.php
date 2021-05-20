<audio id="audioBox">
    <source src="achref.mp3" type="audio/wav">
</audio>
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    setInterval(function (){load();},3000);
    function load(){
        jQuery.ajax({url:'get.php',success:function (result){
            var data=jQuery.parseJSON(result);
            if(data.sound=="yes"){
                jQuery('#audioBox')[0].play();
            }
            }})
    }
</script>