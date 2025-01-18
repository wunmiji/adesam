<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Terms',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Terms',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>



<?php //https://www.termsofservicegenerator.net/live.php?token=EwSlLpXa6x2aawquxKebQzKLVEnnxvVi ?>
<?php //https://www.termsofservicegenerator.net/live.php?token=EwSlLpXa6x2aawquxKebQzKLVEnnxvVi ?>
<?php //https://www.termsofservicegenerator.net/live.php?token=EwSlLpXa6x2aawquxKebQzKLVEnnxvVi ?>
<!-- terms-section -->
<section class="mb-5">
	<div class="d-flex flex-column row-gap-4">
		<div>
			<h5 class="card-title mb-2">Introduction</h5>
			<p>
				By accessing this Website, accessible from <?= $information['website']; ?>, you are agreeing to
				be bound by these Website Terms and Conditions of Use and agree that you are
				responsible for the agreement with any applicable local laws.
			</p>
			<p>
				If you disagree with
				any of these terms, you are prohibited from accessing this site. The materials
				contained in this Website are protected by copyright and trade mark law.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Use License</h5>

			<p>
				Permission is granted to temporarily download one copy of the materials on Adesam's
				Website for personal, non-commercial transitory viewing only. This is the grant of a
				license, not a transfer of title, and under this license you may not:
			</p>

			<ul>
				<li>modify or copy the materials;</li>
				<li>use the materials for any commercial purpose or for any public display;</li>
				<li>attempt to reverse engineer any software contained on Adesam's Website;</li>
				<li>remove any copyright or other proprietary notations from the materials; or</li>
				<li>transferring the materials to another person or "mirror" the materials on any
					other server.</li>
			</ul>

			<p>
				This will let Adesam to terminate upon violations of any of these restrictions. Upon
				termination, your viewing right will also be terminated and you should destroy any
				downloaded materials in your possession whether it is printed or electronic format.
				These Terms of Service has been created with the help of the Terms Of Service
				Generator.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Disclaimer</h5>

			<p>
				All the materials on Adesam's Website are provided "as is". Adesam makes no
				warranties, may it be expressed or implied, therefore negates all other warranties.
				Furthermore, Adesam does not make any representations concerning the accuracy or
				reliability of the use of the materials on its Website or otherwise relating to such
				materials or any sites linked to this Website.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Limitations</h5>

			<p>
				Adesam or its suppliers will not be hold accountable for any damages that will arise
				with the use or inability to use the materials on Adesam's Website, even if Adesam
				or an authorize representative of this Website has been notified, orally or written,
				of the possibility of such damage. Some jurisdiction does not allow limitations on
				implied warranties or limitations of liability for incidental damages, these
				limitations may not apply to you.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Revisions and Errata</h5>

			<p>
				The materials appearing on Adesam's Website may include technical, typographical, or
				photographic errors. Adesam will not promise that any of the materials in this
				Website are accurate, complete, or current. Adesam may change the materials
				contained on its Website at any time without notice. Adesam does not make any
				commitment to update the materials.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Links</h5>

			<p>
				Adesam has not reviewed all of the sites linked to its Website and is not
				responsible for the contents of any such linked site. The presence of any link does
				not imply endorsement by Adesam of the site. The use of any linked website is at the
				user's own risk.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Site Terms of Use Modifications</h5>

			<p>
				Adesam may revise these Terms of Use for its Website at any time without prior
				notice. By using this Website, you are agreeing to be bound by the current version
				of these Terms and Conditions of Use.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Your Privacy</h5>

			<p>
				Please read our <a href="<?= '/privacy' ?>">Privacy Policy</a>.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Governing Law</h5>

			<p>
				Any claim related to Adesam's Website shall be governed by the laws of ng without
				regards to its conflict of law provisions.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Contact Us</h5>

			<p>If you have any questions about these Terms, You can contact us: </p>

			<ul>
				<li>By email: <?= $information['email']; ?></li>
				<li>By phone number: <?= $information['mobile']; ?></li>
			</ul>
		</div>
	</div>
</section>


<?= $this->endSection(); ?>