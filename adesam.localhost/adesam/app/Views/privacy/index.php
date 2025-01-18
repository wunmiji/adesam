<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Privacy',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Privacy',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>


<?php //https://www.privacypolicytemplate.net/live.php?token=ZWQzBvDpNtJcz5NYtOim6bx9ZbBnaCZz ?>
<?php //https://www.privacypolicytemplate.net/live.php?token=ZWQzBvDpNtJcz5NYtOim6bx9ZbBnaCZz ?>
<?php //https://www.privacypolicytemplate.net/live.php?token=ZWQzBvDpNtJcz5NYtOim6bx9ZbBnaCZz ?>
<!-- privacy-section -->
<section class="mb-5">
	<div class="d-flex flex-column row-gap-4">
		<div>
			<h5 class="card-title mb-2">Introduction</h5>
			<p>
				Adesam operates the <?= $information['website']; ?> website, which provides the SERVICE.
			</p>
			<p>
				This page is used to inform website visitors regarding our policies with the
				collection,
				use, and disclosure of Personal Information if anyone decided to use our Service,
				the
				adesam.com website.

				If you choose to use our Service, then you agree to the collection and use of
				information in
				relation with this policy. The Personal Information that we collect are used for
				providing
				and improving the Service. We will not use or share your information with anyone
				except as
				described in this Privacy Policy.

				The terms used in this Privacy Policy have the same meanings as in our Terms and
				Conditions,
				which is accessible at <?= $information['website']; ?>, unless otherwise defined in this Privacy
				Policy.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Information Collection and Use</h5>

			<p>
				For a better experience while using our Service, we may require you to provide us
				with
				certain personally identifiable information, including but not limited to your name,
				phone
				number, and postal address. The information that we collect will be used to contact
				or
				identify you.
			</p>
		</div>


		<div>
			<h5 class="card-title mb-2">Service Providers</h5>

			<p>
				We may employ third-party companies and individuals due to the following reasons:
			</p>

			<ul>
				<li>To facilitate our Service;</li>
				<li>To provide the Service on our behalf;</li>
				<li>To perform Service-related services; or</li>
				<li>To assist us in analyzing how our Service is used;</li>
			</ul>
			<p>
				We want to inform our Service users that these third parties have access to your
				Personal
				Information. The reason is to perform the tasks assigned to them on our behalf.
				However,
				they are obligated not to disclose or use the information for any other purpose.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Security</h5>

			<p>
				We value your trust in providing us your Personal Information, thus we are striving
				to use
				commercially acceptable means of protecting it. But remember that no method of
				transmission
				over the internet, or method of electronic storage is 100% secure and reliable, and
				we
				cannot guarantee its absolute security.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Links to Other Sites</h5>

			<p>
				Our Service may contain links to other sites. If you click on a third-party link,
				you will
				be directed to that site. Note that these external sites are not operated by us.
				Therefore,
				we strongly advise you to review the Privacy Policy of these websites. We have no
				control
				over, and assume no responsibility for the content, privacy policies, or practices
				of any
				third-party sites or services.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Children's Privacy</h5>

			<p>
				Our Services do not address anyone under the age of 13. We do not knowingly collect
				personal
				identifiable information from children under 13. In the case we discover that a
				child under
				13 has provided us with personal information, we immediately delete this from our
				servers.
				If you are a parent or guardian and you are aware that your child has provided us
				with
				personal information, please contact us so that we will be able to do necessary
				actions.
				Changes to This Privacy Policy
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Changes to This Privacy Policy</h5>

			<p>
				We may update our Privacy Policy from time to time. Thus, we advise you to review
				this page
				periodically for any changes. We will notify you of any changes by posting the new
				Privacy
				Policy on this page. These changes are effective immediately, after they are posted
				on this
				page.
			</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Contact Us</h5>

			<p>If you have any questions about these Privacy Policy, You can contact us: </p>

			<ul>
				<li>By email: <?= $information['email']; ?></li>
				<li>By phone number: <?= $information['mobile']; ?></li>
			</ul>
		</div>
	</div>
</section>


<?= $this->endSection(); ?>