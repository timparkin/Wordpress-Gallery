</div>
</div>

<?php global $woo_options; ?>

	

<div id="footer"> 
  <div id="footercontent"> 
    <div class="row1 clearfix"> 
      <div class="search"> 
        <h3>search</h3> 
        <div class="item"> 
          <p>Use the following form to search this site. <!--Alternatively you may use the advanced search by clicking <a href="#">here"</a>-->.</p> 
        </div> 
        <form action="/search"> 
          <fieldset> 
          <label for="text">search term</label> 
          <input type="text" id="text" name="q" /> 
          <input type="submit" class="action" value="click here to search" /> 
          </fieldset> 
        </form> 
      </div> 
      <div class="subscribe"> 
        <h3>subscribe</h3> 
        <div class="item"> 
          <p>Please send me news alerts about significant news, events or promotions.</p> 
        </div> 
        <form action="/subscribe" accept-charset="utf-8" method="post" id="form" enctype="multipart/form-data"> 
          <fieldset> 
          <input type="hidden" name="_charset_" /> 
          <input type="hidden" name="__nevow_form__" value="form" /> 
          <div class="clearfix"> 
<label for="name">Name</label><input type="text" name="name" id="name" /> 
          </div> 
          <div class="clearfix"> 
<label for="email">Email</label><input type="text" name="email" id="email" /> 
          </div> 
          <div class="clearfix" id="subscribe-humanCheck-field"> 
<label for="subscribe-humanCheck">Tim's Surname</label><input type="text" name="humanCheck" id="subscribe-humanCheck" /> 
          </div> 
          <input type="submit" name="submit" value="click here to subscribe" class="action" /> 
          </fieldset> 
        </form> 
      </div> 
      <div class="info"> 
        <h3>info</h3> 
        <div class="label"> 
          <img src="<?php echo get_template_directory_uri(); ?>/images/timparkin.jpg" alt="landscape photographer" /> 
        </div> 
        <div class="item"> 
 
          
  <p>Tim Parkin<br />237 Lidgett Lane<br />Leeds<br />West Yorkshire<br />UK<br />LS17 6QR</p> 
  <p>+44 (0)113 216 7634</p> 
  <p><a href="mailto:info@timparkin.co.uk">info@timparkin.co.uk</a></p> 
  
          
          <?php if($woo_options['woo_footer_left'] == 'true'){
		
				echo stripslashes($woo_options['woo_footer_left_text']);	

		} else { ?>
			<p>&copy; <?php echo date('Y'); ?> Tim Parkin.</p><p><?php _e('All Rights Reserved.', 'woothemes') ?></p>
		<?php } ?>

  
        
        </div> 
      </div> 
    </div> 
  </div> 
  
</div> 
 
<script type="text/javascript"> 
<!--//--><![CDATA[//><!--
sIFR.replace(helvetica, { selector: 'h2.sifr', css: ['.sIFR-root { background-color: #FFFFFF; color: #000000; font-size: 20px; }','a {text-decoration: none; color: #000000; }', 'a:hover { color: #000000; }'] });
sIFR.replace(helvetica, { selector: '#content h2', css: ['.sIFR-root { background-color: #FFFFFF; color: #000000; font-size: 15px; }'] });
sIFR.replace(helvetica, { selector: 'h3.sifr', css: ['.sIFR-root { background-color: #FFFFFF; color: #000000; font-size: 20px; }','a {text-decoration: none; color: #222222; }', 'a:hover { color: #222222; }' ] });
sIFR.replace(helvetica, { selector: 'h4.sifr', css: ['.sIFR-root { background-color: #FFFFFF; color: #000000; font-size: 20px; }'] });
//--><!]]>
</script> 
<script type="text/javascript"> 
<!--//--><![CDATA[//><!--
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
//--><!]]>
</script> 
<script type="text/javascript"> 
<!--//--><![CDATA[//><!--
var pageTracker = _gat._getTracker("UA-6194229-1");
pageTracker._setCookieTimeout("86400");
pageTracker._trackPageview();
//--><!]]>
</script> 
<?php wp_footer(); ?>
<?php woo_foot(); ?>





