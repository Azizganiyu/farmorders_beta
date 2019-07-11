<section class="contact-banner">
    <div class="container">
        <h2>Talk to us</h2>
        <p>Are you curious about something? Do you have some kind of problem with our products? <br/> Please feel free to contact us, our customer service center is working for you 24/7.</p>
    </div>
</section>
<section>
	<div class="container contact-options">
		<div class="row">
			<div class="col-md-4 option call">
				<h4>Call Center</h4>
				<p>Call to this numbers incures charges otherwise we advise you to use the electronic form of communication.</p>

					<li><i class="fa fa-arrow-circle-right"></i> 08123645460</li>
					<li><i class="fa fa-arrow-circle-right"></i> 07033968518 </li>
					<li><i class="fa fa-arrow-circle-right"></i> 08079028695</li>

			</div>
			<div class="col-md-4 option social">
				<h4>Social Platform</h4>
				<p>Reach us on any of our social patform</p>
				<a href="#" class="fab fa-facebook"> farmorders</a>
				<a href="https://instagram.com/farmorders_beta.com.ng" class="fab fa-instagram"> farmorders</a>
				<a href="#" class="fab fa-twitter"> farmorders</a>
				<a href="#" class="fab fa-whatsapp"> 08123645460</a>
			</div>
			<div class="col-md-4 option mail">
				<h4>Electronic Mail</h4>
				<p>Please feel free to write an email to us</p>
				<a href="mailto:" class="fa fa-envelope"> farmorders.com.ng@gmail.com</a>
			</div>
		</div>
	</div>
</section>
<section class="contact-form">
	<div class="container">
		<div class="col-12 col-md-6 form-box">
			<?php echo form_open('/page/process_mail'); ?>
            <h3 class="form_title"> Contact Us </h3>
            <p>Please send your message below, we will get back to you as soon as possible</p>
            <textarea name="message" required placeholder="Your Message"></textarea>
            <input type="text" required name="name" placeholder="Your Name">
            <input type="text"  required name="email" placeholder="Your Email">
            <div id="mail-info"></div>
            <button type="submit" name="submit_email" class="btn btn-md btn-light">Send</button>
        </form>
		</div>
	</div>
</section>