<style>
  .loader {
    width: 48px;
    height: 48px;
    border: 5px solid #FFF;
    border-bottom-color: #3498db;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
  }
  
  @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
  } 
</style>

<script>
  function loader(data) {
    if (data == 'show') {
      $('html, body').css('overflow', 'hidden');
      $('.bg-loader').css("display", "block");
      $('.loader').css("display", "block");
    } else {
      $('html, body').css('overflow', 'auto');
      $('.bg-loader').css("display", "none");
      $('.loader').css("display", "none");
    }
  }
</script>

