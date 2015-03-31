<?php
  $message = '<div class="12u" style="text-align:center;width:100%"><div class="clock"></div></div>
  <style type="text/css">
  .flip-clock-label{
    display: none;
  }

  .clock{
    margin:2em auto; text-align:center;
  }

  @media screen and (min-width: 500px) {
    .clock{
      width:460px
    }
  }

  @media screen and (max-width: 500px) {
    .clock{
      zoom:0.5;
      width:460px
    }
  }

  </style>
  <div class="message"></div><script type="text/javascript">
		var clock;

		$(document).ready(function() {
			var clock;

			clock = $(\'.clock\').FlipClock({
		        clockFace: \'HourlyCounter\',
		        autoStart: false,
		        callbacks: {
		        	stop: function() {
		        		'.$stop_callback_js.'
		        	}
		        }
		    });

		    clock.setTime('.$time.');
		    clock.setCountdown(true);
		    clock.start();

		});
	</script>';
  include 'message.php';
?>
