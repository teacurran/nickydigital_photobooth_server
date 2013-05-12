<?php

namespace NickyDigital\PhotoboothBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Facebook;
use FacebookApiException;
use NickyDigital\PhotoboothBundle\Entity\Account;
use NickyDigital\PhotoboothBundle\Entity\Email;
use NickyDigital\PhotoboothBundle\Entity\EmailShare;
use NickyDigital\PhotoboothBundle\Entity\FacebookShare;
use NickyDigital\PhotoboothBundle\Entity\Photo;
use NickyDigital\PhotoboothBundle\Entity\PhotoEvent;
use NickyDigital\PhotoboothBundle\Entity\TwitterShare;
use NickyDigital\PhotoboothBundle\Entity\TumblrShare;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\Finder\Finder;
use Doctrine\ORM\EntityManager;
use NickyDigital\PhotoboothBundle\Util\ResizedImage;

use tmhOAuth;
use tmhUtilities;

/**
 * User: T. Curran
 * Date: 2/10/13
 */
/**
 * @Route("/")
 */
class ApiController extends FOSRestController
{

	/**
	 *
	 * @var EntityManager
	 */
	protected $em;

	protected $facebook;
	protected $event;
	
	protected $thumb_width = 300;
	protected $detail_width = 640;
	protected $twitter_width = 1024;
	protected $facebook_width = 1024;
	protected $tumblr_width = 1024;

	protected $defaultFacebookConsumerKey = '596065173744275';
	protected $defaultFacebookConsumerSecret = '272dec3fa799dc5751205642ad90318a';

	protected $defaultTwitterConsumerKey = 'MsXMqyi2TzVipDTA6vpvw';
	protected $defaultTwitterConsumerSecret = 'P9quxz9SXZY3wtr3f258zQPl7XDmhh4zsh4DlKpc';

	protected $defaultTumblrConsumerKey = 'tSISWrYGOOcg0L9HlAJuHxnqxIRmSZjD66mGUvqiyP47UT60cQ';
	protected $defaultTumblrConsumerSecret = '87ALrtQs5HqMGvxKRLIMQYcRbIoFWSGJHAnDJX7yPqKhJtHP9I';

	public function __construct() {
	}
	
	
	/**
	 * @Route("/event", name="api_event")
	 * @Method({"GET"})
	 * @Rest\View
	 */
	public function eventAction()
	{

		$event = $this->getCurrentEvent();

		if ($event->getEventCode() == "default") {
			return array(
				"id" => 0,
				"code" => $event->getEventCode(),
				"name" => $event->getEventName(),
			);
			
		}
		
		$bannerImage = "";
		$rootDir = $this->container->get('kernel')->getRootdir(); 
		$bannerFile = $rootDir . "/../web/event/" . $event->getEventCode() . ".png";
		if (file_exists($bannerFile)) {
			$bannerImage  = "/event/" . $event->getEventCode() . ".png";
		}
		$bannerFile = $rootDir . "/../web/event/" . $event->getEventCode() . ".jpg";
		if (file_exists($bannerFile)) {
			$bannerImage  = "/event/" . $event->getEventCode() . ".jpg";
		}

		$facebookConsumerKey = $this->defaultFacebookConsumerKey;
		if (trim($event->getFacebookConsumerKey()) != "") {
			$facebookConsumerKey = trim($event->getFacebookConsumerKey());
		}

		$facebookConsumerSecret = $this->defaultFacebookConsumerSecret;
		if (trim($event->getFacebookConsumerSecret()) != "") {
			$facebookConsumerSecret = trim($event->getFacebookConsumerSecret());
		}

		$twitterConsumerKey = $this->defaultFacebookConsumerKey;
		if (trim($event->getFacebookConsumerKey()) != "") {
			$twitterConsumerKey = trim($event->getFacebookConsumerKey()); 
		}

		$twitterConsumerSecret = $this->defaultFacebookConsumerSecret;
		if (trim($event->getFacebookConsumerSecret()) != "") {
			$twitterConsumerSecret = trim($event->getFacebookConsumerSecret()); 
		}

		$tumblrConsumerKey = $this->defaultTumblrConsumerKey;
		if (trim($event->getTumblrConsumerKey()) != "") {
			$tumblrConsumerKey = trim($event->getTumblrConsumerKey());
		}

		$tumblrConsumerSecret = $this->defaultTumblrConsumerSecret;
		if (trim($event->getTumblrConsumerSecret()) != "") {
			$tumblrConsumerSecret = trim($event->getTumblrConsumerSecret());
		}

		return array(
			"id" => $event->getId(),
			"code" => $event->getEventCode(),
			"banner" => $bannerImage,
			"name" => $event->getEventName(),
			"album_name" => $event->getAlbumName(),
			"short_share" => $event->getShortShareText(),
			"long_share" => $event->getLongShareText(),
			"email_share" => $event->getEmailShareText(),
			"tumblr_share" => $event->getTumblrShareText(),
			"show_facebook" => $event->getShowFacebook(),
			"show_twitter" => $event->getShowTwitter(),
			"show_tumblr" => $event->getShowTumblr(),
			"show_email" => $event->getShowEmail(),
			"show_waterfall" => $event->getShowWaterfall(),
			"show_facebook_like" => $event->getShowFacebookLike(),
			"facebook_like_text" => $event->getFacebookLikeText(),
			"facebook_like_url" => $event->getFacebookLikeUrl(),
			"tumblr_consumer_key" => $tumblrConsumerKey,
			"tumblr_consumer_secret" => $tumblrConsumerSecret,
			"twitter_consumer_key" => $twitterConsumerKey,
			"twiter_consumer_secret" => $twitterConsumerSecret,
			"facebook_consumer_key" => $facebookConsumerKey,
			"facebook_consumer_secret" => $facebookConsumerSecret,
			"thumb_aspect" => $event->getThumbAspect()
		);
	
	}

	/**
	 * @Route("/photos", name="api_photos")
	 * @Method({"GET"})
	 * @Rest\View
	 */
	public function photosAction()
	{

		$event = $this->getCurrentEvent();

		$photoListArray = Array();

		$finder = new Finder();

		$filesDir = $this->getPhotoDir($event);
		if (!$this->rmkdir($filesDir)) {
			die("Failed to create folders:" . $filesDir);
		}

		$sort = function (\SplFileInfo $a, \SplFileInfo $b) {
		    return $a->getMTime() > $b->getMTime();
		};

		$finder->files()->in($filesDir)->sort($sort);

		$imagesGenerated = 0;
		$thumbFileDir = $this->getCacheDir() . "/" . $event->getEventCode() . "/" . $this->thumb_width;
		$detailFileDir = $this->getCacheDir() . "/" . $event->getEventCode() . "/" . $this->detail_width;
		
		
		$i = 0;
		foreach ($finder as $file) {
			$filename = $file->getFilename();

			// TODO: why is true here? were the strpos not working?
			if (true || strpos($filename, '.gif', 1) || strpos($filename, '.jpg', 1)) {

				$originalFilename = $filesDir . "/" . $filename;
				$thumbFilename = $thumbFileDir . "/" . $filename;
				$detailFilename = $detailFileDir . "/" . $filename;
		
				// Generate a thumbnail
				if (!file_exists($thumbFilename) && $imagesGenerated < 1) {
		
					if (!$this->rmkdir($thumbFileDir)) {
						die('Failed to create folders');
					}
		
					$resizedImage = new ResizedImage();
					$resizedImage->load($originalFilename);
					$resizedImage->resizeToWidth($this->thumb_width);
					$resizedImage->save($thumbFilename);
					$imagesGenerated++;
				}

				// Only tell the client about the photo after a thumb has been created.
				if (file_exists($thumbFilename)) {
					$i++;
					$photo = array();
					$photo['filename'] = $filename;
	
					array_push($photoListArray, $photo);
				}
			}
		}

		// THis is slowing things down
		// loop again if we are generate detail views if we don't have any thumbs to generate;
		//if ($imagesGenerated < 1) {
		//	foreach ($finder as $file) {
		//		$filename = $file->getFilename();
		//
		//		$originalFilename = $filesDir . "/" . $filename;
		//		$thumbFilename = $thumbFileDir . "/" . $filename;
		//		$detailFilename = $detailFileDir . "/" . $filename;
		//
		//		// Generate a detail sized image
		//		if (!file_exists($detailFilename) && $imagesGenerated < 1) {
		//
		//			if (!$this->rmkdir($thumbFileDir)) {
		//				die('Failed to create folders');
		//			}
		//
		//			$resizedImage = new ResizedImage();
		//			$resizedImage->load($originalFilename);
		//			$resizedImage->resizeToWidth($this->detail_width);
		//			$resizedImage->save($detailFilename);
		//			$imagesGenerated++;
		//		}
		//	}
		//}

		return $photoListArray;
	}

	/**
	 * @Route("/photo/{width}/{filename}", name="api_photo")
	 * @Method({"GET"})
	 */
	public function photoAction($width, $filename)
	{

		if ($width != "original") {
			if (!is_numeric($width)) {
				throw $this->createNotFoundException('Width must be a number');
			}

		}

		$event = $this->getCurrentEvent();

		$filesDir = $this->getPhotoDir($event);

		$originalFilename = $filesDir . "/" . $filename;
		$sizedFileDir = $this->getCacheDir() . "/" . $event->getEventCode() . "/" . $width;
		$sizedFilename = $sizedFileDir . "/" . $filename;

		if (!file_exists($originalFilename)) {
			throw $this->createNotFoundException('The photo does not exist');
		}

		if ($width == "original") {
			$sizedFilename = $originalFilename;
		} elseif (!file_exists($sizedFilename)) {

			if (!$this->rmkdir($sizedFileDir)) {
				die('Failed to create folders');
			}

			$resizedImage = new ResizedImage();
			$resizedImage->load($originalFilename);
			$resizedImage->resizeToWidth($width);
			$resizedImage->save($sizedFilename);
		}

		$sizedHandle = fopen($sizedFilename, 'r');
		$fileSize = filesize($sizedFilename);

		$response = new Response();
		//$response = $this->getResponse();
		$response->headers->set('Last-Modified', date('r', strtotime(filemtime($originalFilename))));
		$response->headers->set('Content-Type', 'image/jpeg');
		$response->headers->set('Content-Length', $fileSize);

		$response->setContent(fread($sizedHandle, $fileSize));

		fclose($sizedHandle);

		return $response;
	}

	/**
	 * @Route("/emailcapture", name="api_emailcapture")
	 * @Method({"POST"})
	 */
	public function emailcaptureAction(Request $request)
	{
		$emailAddress = trim($request->request->get("email"));
		if ($emailAddress != "") {
			$email = new Email();
			
			$email->setEvent($this->getCurrentEvent());
			$email->setEmail($emailAddress);
	
			$this->em = $this->get('doctrine.orm.entity_manager');
	
			$this->em->persist($email);
			$this->em->flush();
		}

		return array("status" => "success");
	}

	/**
	 * @Route("/facebookshare", name="api_facebookshare")
	 * @Method({"POST"})
	 */
	public function facebookshareAction(Request $request)
	{

		$event = $this->getCurrentEvent();
		
		$email = $request->request->get("email");
		$token = $request->request->get("token");
		$filename = $request->request->get("filename");
		$body = $request->request->get("body");
		$like = $request->request->get("like");

		if ($body == "") {
			$body = $event->getLongShareText();
		}

		$query = $this->em->createQuery('SELECT p FROM NickyDigital\PhotoboothBundle\Entity\Photo p WHERE p.event=:event AND p.filename=:filename');
		$query->setParameter("event", $event);
		$query->setParameter("filename", $filename);
		$photos = $query->getResult();

		
		if (count($photos) > 0) {
			$photo = $photos[0];
		} else {
			$photo = new Photo();
			$photo->setFilename($filename);
			$photo->setEvent($event);
			$photo->setDeleted(false);
			$photo->setMissing(false);
			$this->em->persist($photo);
			$this->em->flush();
		}
		
		
		$share = new FacebookShare();
		$share->setEmail($email);
		$share->setOauthToken($token);
		$share->setPhoto($photo);
		$share->setBody($body);
		$share->setStatus("queue");
		$share->setOauthCode("");

		$share->setLikeIncluded(false);
		if ($like == "true") {
			$share->setLikeIncluded(true);
		}

		$this->em = $this->get('doctrine.orm.entity_manager');
		$this->em->persist($share);
		$this->em->flush();

		return array("status" => "success");
	}

	/**
	 * @Route("/twittershare", name="api_twitter")
	 * @Method({"POST"})
	 */
	public function twittershareAction(Request $request)
	{

		$event = $this->getCurrentEvent();
		
		$token = $request->request->get("token");
		$tokensecret = $request->request->get("tokensecret");
		$filename = $request->request->get("filename");
		$body = $request->request->get("body");

		if ($body == "") {
			$body = $event->getShortShareText();
		}

		$query = $this->em->createQuery('SELECT p FROM NickyDigital\PhotoboothBundle\Entity\Photo p WHERE p.event=:event AND p.filename=:filename');
		$query->setParameter("event", $event);
		$query->setParameter("filename", $filename);
		$photos = $query->getResult();

		
		if (count($photos) > 0) {
			$photo = $photos[0];
		} else {
			$photo = new Photo();
			$photo->setFilename($filename);
			$photo->setEvent($event);
			$photo->setDeleted(false);
			$photo->setMissing(false);
			$this->em->persist($photo);
			$this->em->flush();
		}
		
		
		$share = new TwitterShare();
		// TODO: get their actual username or drop this field.
		
		$share->setUsername("username");
		$share->setOauthToken($token);
		$share->setOauthSecret($tokensecret);
		$share->setPhoto($photo);
		$share->setShareText($body);
		$share->setStatus("queue");

		$this->em = $this->get('doctrine.orm.entity_manager');
		$this->em->persist($share);
		$this->em->flush();

		return array("status" => "success");
	}

	/**
	 * @Route("/tumblrshare", name="api_tumblrshare")
	 * @Method({"POST"})
	 */
	public function tumblrshareAction(Request $request)
	{

		$event = $this->getCurrentEvent();
		
		$token = $request->request->get("token");
		$tokensecret = $request->request->get("tokensecret");
		$hostname = $request->request->get("hostname");
		$username = $request->request->get("username");
		$filename = $request->request->get("filename");
		$body = $request->request->get("body");

		if ($body == "") {
			$body = $event->getShortShareText();
		}

		$query = $this->em->createQuery('SELECT p FROM NickyDigital\PhotoboothBundle\Entity\Photo p WHERE p.event=:event AND p.filename=:filename');
		$query->setParameter("event", $event);
		$query->setParameter("filename", $filename);
		$photos = $query->getResult();

		
		if (count($photos) > 0) {
			$photo = $photos[0];
		} else {
			$photo = new Photo();
			$photo->setFilename($filename);
			$photo->setEvent($event);
			$photo->setDeleted(false);
			$photo->setMissing(false);
			$this->em->persist($photo);
			$this->em->flush();
		}
		
		
		$share = new TumblrShare();
		// TODO: get their actual username or drop this field.
		
		$share->setUsername($username);
		$share->setHostname($hostname);
		$share->setOauthToken($token);
		$share->setOauthSecret($tokensecret);
		$share->setPhoto($photo);
		$share->setBody($body);
		$share->setStatus("queue");

		$this->em = $this->get('doctrine.orm.entity_manager');
		$this->em->persist($share);
		$this->em->flush();

		return array("status" => "success");
	}

	/**
	 * @Route("/emailshare", name="api_emailshare")
	 * @Method({"POST"})
	 */
	public function emailshareAction(Request $request)
	{

		$event = $this->getCurrentEvent();
		
		$emailFrom = $request->request->get("email_from");
		$emailTo = $request->request->get("email_to");
		$emailBody = $request->request->get("email_body");
		$filename = $request->request->get("filename");

		if ($emailBody == "") {
			$emailBody = $event->getEmailShareText();
		}

		$query = $this->em->createQuery('SELECT p FROM NickyDigital\PhotoboothBundle\Entity\Photo p WHERE p.event=:event AND p.filename=:filename');
		$query->setParameter("event", $event);
		$query->setParameter("filename", $filename);
		$photos = $query->getResult();

		if (count($photos) > 0) {
			$photo = $photos[0];
		} else {
			$photo = new Photo();
			$photo->setFilename($filename);
			$photo->setEvent($event);
			$photo->setDeleted(false);
			$photo->setMissing(false);
			$this->em->persist($photo);
			$this->em->flush();
		}
		
		$emailSubject = $event->getEmailShareSubject();
		if ($emailSubject == null || $emailSubject == "") {
			$emailSubject = "Photo from Nicky Digital";
		}
		
		$share = new EmailShare();
		$share->setSubject($emailSubject);
		$share->setEmailFrom($emailFrom);
		$share->setEmailTo($emailTo);
		$share->setBody($emailBody);
		$share->setPhoto($photo);
		$share->setStatus("queue");

		$this->em = $this->get('doctrine.orm.entity_manager');
		$this->em->persist($share);
		$this->em->flush();

		return array("status" => "success");
	}


	/**
	 * @Route("/processemails", name="api_processemails")
	 * @Method({"GET"})
	 */
	public function processemailsAction(Request $request)
	{

		$this->em = $this->get('doctrine.orm.entity_manager');
		$event = $this->getCurrentEvent();

		$query = $this->em->createQuery('SELECT s FROM NickyDigital\PhotoboothBundle\Entity\EmailShare s WHERE s.status=:status');
		$query->setParameter("status", "queue");
		$query->setMaxResults(2);
		$uploads = $query->getResult();

		if (count($uploads) > 0) {
			foreach($uploads as $upload) {
				$upload->setStatus("uploading");
				$this->em->persist($upload);
				$this->em->flush();

				$filename = $upload->getPhoto()->getFilename();
				$filesDir = $this->getPhotoDir($event);

				$originalFilename = $filesDir . "/" . $filename;
				$sizedFileDir = $this->getCacheDir() . "/" . $event->getEventCode() . "/" . $this->facebook_width;
				$sizedFilename = $sizedFileDir . "/" . $filename;

				if (!file_exists($sizedFilename)) {
	
					if (!$this->rmkdir($sizedFileDir)) {
						die('Failed to create folders');
					}

					$resizedImage = new ResizedImage();
					$resizedImage->load($originalFilename);
					$resizedImage->resizeToWidth($this->facebook_width);
					$resizedImage->save($sizedFilename);
				}

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_VERBOSE, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
				curl_setopt($ch, CURLOPT_URL, "http://wirelust.com/nickydigital/upload.php");
				curl_setopt($ch, CURLOPT_POST, true);
				// same as <input type="file" name="file_box">
				$post = array(
					"file"=>"@" . $sizedFilename,
					"event"=>$event->getEventCode(),
					"email_from"=>$upload->getEmailFrom(),
					"email_to"=>$upload->getEmailTo(),
					"email_body"=>$upload->getBody(),
					"email_subject"=>$upload->getSubject(),
				);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
				$response = curl_exec($ch);

				$upload->setServerResponse($response);
				$upload->setStatus("complete");

				$this->em->persist($upload);
				$this->em->flush();
			}
		}
		
	
		return array("status" => "success");
	}
	
	/**
	 * @Route("/processuploads", name="api_processuploads")
	 * @Method({"GET"})
	 */
	public function processuploadsAction(Request $request)
	{

		
		$logger = $this->get('logger');

		$this->em = $this->get('doctrine.orm.entity_manager');

		$event = $this->getCurrentEvent();

		$query = $this->em->createQuery('SELECT s FROM NickyDigital\PhotoboothBundle\Entity\FacebookShare s WHERE s.status=:status');
		$query->setParameter("status", "queue");
		$query->setMaxResults(2);
		$uploads = $query->getResult();

		if (count($uploads) > 0) {

			$facebookConsumerKey = $this->defaultFacebookConsumerKey;
			if (trim($event->getFacebookConsumerKey()) != "") {
				$facebookConsumerKey = trim($event->getFacebookConsumerKey());
			}

			$facebookConsumerSecret = $this->defaultFacebookConsumerSecret;
			if (trim($event->getFacebookConsumerSecret()) != "") {
				$facebookConsumerSecret = trim($event->getFacebookConsumerSecret());
			}

			
			foreach($uploads as $upload) {
				
				session_start();
				$this->facebook = new Facebook(array(
				    'appId' => $facebookConsumerKey,
				    'secret' => $facebookConsumerSecret,
				));		
				
				$upload->setStatus("uploading");
				$this->em->persist($upload);
				$this->em->flush();

				$filename = $upload->getPhoto()->getFilename();
				$filesDir = $this->getPhotoDir($event);

				$originalFilename = $filesDir . "/" . $filename;
				$sizedFileDir = $this->getCacheDir() . "/" . $event->getEventCode() . "/" . $this->facebook_width;
				$sizedFilename = $sizedFileDir . "/" . $filename;

				if (!file_exists($sizedFilename)) {
	
					if (!$this->rmkdir($sizedFileDir)) {
						die('Failed to create folders');
					}

					$resizedImage = new ResizedImage();
					$resizedImage->load($originalFilename);
					$resizedImage->resizeToWidth($this->facebook_width);
					$resizedImage->save($sizedFilename);
				}

				$this->facebook->setAccessToken($upload->getOauthToken());

				$album_uid = null;
				$albums = $this->facebook->api('/me/albums');
				foreach($albums['data'] as $album)  {
					if ($album['name'] == $event->getAlbumName()) {
						$album_uid = $album['id'];
					}
				}
				
				$this->facebook->setFileUploadSupport(true);

				//Create an album
				if ($album_uid == null) {
					$album_details = array(
							'message'=> $event->getAlbumDesc(),
							'name'=> $event->getAlbumName()
					);
					$create_album = $this->facebook->api('/me/albums', 'post', $album_details);
					  
					//Get album ID of the album you've just created
					$album_uid = $create_album['id'];
				}
  
				//Upload a photo to album of ID...
				$photo_details = array(
					'message' => $upload->getBody()
				);

				$photo_details['image'] = '@' . $sizedFilename;
  
				$upload_photo = $this->facebook->api('/'.$album_uid.'/photos', 'post', $photo_details);

				$upload->setStatus("complete");
				$this->em->persist($upload);
				$this->em->flush();

				$facebookId = $this->facebook->getUser();

				if ($facebookId) {
					
					$facebookUser = $this->facebook->api('/me', 'GET');

					if ($upload->getAccount() == null) {
						$query = $this->em->createQuery('SELECT a FROM NickyDigital\PhotoboothBundle\Entity\Account a WHERE a.facebookId=:facebookId');
						$query->setParameter("facebookId", $facebookId);
						$accounts = $query->getResult();
				
						if (count($accounts) > 0) {
							$account = $accounts[0];
						} else {
							$account = new Account();
						}
					} else {
						$account = $upload->getAccount();
					}
					$account->setFacebookId($facebookId);
					if (array_key_exists("name", $facebookUser)) {
						$account->setName($facebookUser["name"]);
					}
					if (array_key_exists("gender", $facebookUser)) {
						$account->setGender($facebookUser['gender']);
					}
					if (array_key_exists("location", $facebookUser)) {
						$account->setLocation($facebookUser['location']['name']);
					}
					if (array_key_exists("birthday", $facebookUser)) {
						$account->setBirthday($facebookUser['birthday']);
					}
					if (array_key_exists("username", $facebookUser)) {
						$account->setFacebookUsername($facebookUser['username']);
					}
					if (array_key_exists("email", $facebookUser)) {
						$account->setEmail($facebookUser['email']);
						$upload->setEmail($facebookUser['email']);
					}

					$upload->setAccount($account);

					$this->em->persist($upload);
					$this->em->persist($account);
					$this->em->flush();
					
					//$facebookShareCountQuery = $this->em->createQuery('SELECT COUNT(s.id) FROM NickyDigital\PhotoboothBundle\Entity\FacebookShare s WHERE s.account_id=:account_id');
					//$facebookShareCountQuery->setParameter("account_id", $account->getId());
					//$facebookShareCount = $facebookShareCountQuery->getSingleScalarResult();

					if ($upload->getLikeIncluded() == true) {
						//$this->facebook->api
						
						//https://graph.facebook.com/[User FB ID]/og.likes?object=OG_OBJECT_URL&access_token=USER_ACCESS_TOKEN
						try {
							$result = $this->facebook->api("/me/og.likes?" . "object=" . $event->getFacebookLikeUrl() . "&access_token=" . $upload->getOauthToken(), 'POST');
						} catch (FacebookApiException $e) {
							// do nothing, this is non critical
						}
					}
				}

			} 
		}

		$this->processTwitterUploadsAction($request);
		$this->processemailsAction($request);
		$this->processTumblrUploadsAction($request);
		
		return array("status" => "success");
	}

	/**
	 * @Route("/processTwitterUploads", name="api_process_twitter_uploads")
	 * @Method({"GET"})
	 */
	public function processTwitterUploadsAction(Request $request)
	{
		$logger = $this->get('logger');

		$this->em = $this->get('doctrine.orm.entity_manager');

		$event = $this->getCurrentEvent();

		// Process Twitter uploads
		$query = $this->em->createQuery('SELECT s FROM NickyDigital\PhotoboothBundle\Entity\TwitterShare s WHERE s.status=:status');
		$query->setParameter("status", "queue");
		$query->setMaxResults(2);
		$uploads = $query->getResult();

		if (count($uploads) > 0) {

			$twitterConsumerKey = $this->defaultFacebookConsumerKey;
			if (trim($event->getFacebookConsumerKey()) != "") {
				$twitterConsumerKey = trim($event->getFacebookConsumerKey()); 
			}

			$twitterConsumerSecret = $this->defaultFacebookConsumerSecret;
			if (trim($event->getFacebookConsumerSecret()) != "") {
				$twitterConsumerSecret = trim($event->getFacebookConsumerSecret()); 
			}

			foreach($uploads as $upload) {

				$upload->setStatus("uploading");
				$this->em->persist($upload);
				$this->em->flush();

				$filename = $upload->getPhoto()->getFilename();
				$filesDir = $this->getPhotoDir($event);

				$originalFilename = $filesDir . "/" . $filename;
				$sizedFileDir = $this->getCacheDir() . "/" . $event->getEventCode() . "/" . $this->twitter_width;
				$sizedFilename = $sizedFileDir . "/" . $filename;

				if (!file_exists($sizedFilename)) {
	
					if (!$this->rmkdir($sizedFileDir)) {
						die('Failed to create folders');
					}

					$resizedImage = new ResizedImage();
					$resizedImage->load($originalFilename);
					$resizedImage->resizeToWidth($this->twitter_width);
					$resizedImage->save($sizedFilename);
				}

				$tmhOAuth = new tmhOAuth(array(
						 'consumer_key'    => $twitterConsumerKey,
						 'consumer_secret' => $twitterConsumerSecret,
						 'user_token'      => $upload->getOauthToken(),
						 'user_secret'     => $upload->getOauthSecret(),
				));
		
				$image = $this->getPhotoDir($event) . "/" . $upload->getPhoto()->getFilename();
			
				$tweetText = $upload->getShareText();
				
				if (substr($tweetText, 0, 1) == "@") {
					$tweetText = "." . $tweetText;
				}

				//$code = $tmhOAuth->request( 'POST','https://upload.twitter.com/1/statuses/update_with_media.json',
				$code = $tmhOAuth->request( 'POST','https://api.twitter.com/1.1/statuses/update_with_media.json',
				   array(
						'media[]'  => "@{$sizedFilename};type=image/jpeg;filename={$upload->getPhoto()->getFilename()}",
						'status'   => $tweetText,
				   ),
					true, // use auth
					true  // multipart
				);
			
				$upload->setServerResponse($tmhOAuth->response['raw']);

				if ($code == 200){
					$upload->setStatus("complete");
				}else{
					$upload->setStatus("failed");

					$logger->err($tmhOAuth->response['response']);
				}
				$this->em->persist($upload);
				$this->em->flush();
			}
		}
	}

	/**
	 * @Route("/processTumblrUploads", name="api_process_tumblr_uploads")
	 * @Method({"GET"})
	 */
	public function processTumblrUploadsAction(Request $request)
	{
		$logger = $this->get('logger');

		$this->em = $this->get('doctrine.orm.entity_manager');

		$event = $this->getCurrentEvent();

		$query = $this->em->createQuery('SELECT s FROM NickyDigital\PhotoboothBundle\Entity\TumblrShare s WHERE s.status=:status');
		$query->setParameter("status", "queue");
		$query->setMaxResults(2);
		$uploads = $query->getResult();

		if (count($uploads) > 0) {

			$tumblrConsumerKey = $this->defaultTumblrConsumerKey;
			if (trim($event->getTumblrConsumerKey()) != "") {
				$tumblrConsumerKey = trim($event->getTumblrConsumerKey());
			}
	
			$tumblrConsumerSecret = $this->defaultTumblrConsumerSecret;
			if (trim($event->getTumblrConsumerSecret()) != "") {
				$tumblrConsumerSecret = trim($event->getTumblrConsumerSecret());
			}

			foreach($uploads as $upload) {
				$upload->setStatus("uploading");
				$this->em->persist($upload);
				$this->em->flush();

				$filename = $upload->getPhoto()->getFilename();
				$filesDir = $this->getPhotoDir($event);

				$originalFilename = $filesDir . "/" . $filename;
				$sizedFileDir = $this->getCacheDir() . "/" . $event->getEventCode() . "/" . $this->twitter_width;
				$sizedFilename = $sizedFileDir . "/" . $filename;

				if (!file_exists($sizedFilename)) {
	
					if (!$this->rmkdir($sizedFileDir)) {
						die('Failed to create folders');
					}

					$resizedImage = new ResizedImage();
					$resizedImage->load($originalFilename);
					$resizedImage->resizeToWidth($this->twitter_width);
					$resizedImage->save($sizedFilename);
				}

				$postUrl = "https://api.tumblr.com/v2/blog/{$upload->getHostname()}/post";

				$tmhOAuth = new tmhOAuth(array(
						 'host'            => $postUrl,
						 'consumer_key'    => $tumblrConsumerKey,
						 'consumer_secret' => $tumblrConsumerSecret,
						 'user_token'      => $upload->getOauthToken(),
						 'user_secret'     => $upload->getOauthSecret(),
				));
		
			
				$postBody = $upload->getBody();
				
				if (substr($postBody, 0, 1) == "@") {
					$postBody = " " . $postBody;
				}

				$dataArray = array(file_get_contents($sizedFilename));
				$postData = array(
							'data'		=> $dataArray,
							'type'		=> 'photo',
							'caption'   => $postBody,
						);
				if ($event->getTumblrTags() != "") {
					$postData['tags'] = $event->getTumblrTags(); 
				}
				if ($event->getTumblrUrl() != "") {
					$postData['source'] = $event->getTumblrUrl(); 
				}
				
				$code = $tmhOAuth->request( 'POST', $postUrl,
				   $postData,
					true, // use auth
					false  // multipart
				);
			
				$upload->setServerResponse($tmhOAuth->response['raw']);

				if ($code == 200){
					$upload->setStatus("complete");
				}else{
					$upload->setStatus("failed");

					$logger->err($tmhOAuth->response['response']);
				}
				$this->em->persist($upload);
				$this->em->flush();


			}
		}

		return array("status" => "success");
	}


	private function getPhotoDir(PhotoEvent $event)
	{
		if ($event->getFolder() != "") {
			return $event->getFolder(); 
		}
		$rootDir = $this->container->get('kernel')->getRootdir(); 

		return substr($rootDir, 0, strlen($rootDir) - 4) . "/photos" . "/" . $event->getEventCode();
	}

	private function getCacheDir()
	{
		return $this->container->get('kernel')->getRootdir() . "/cache/media";
	}

	/**
	 * Makes directory and returns BOOL(TRUE) if exists OR made.
	 *
	 * @param  $path Path name
	 * @return bool
	 */
	function rmkdir($path, $mode = 0777)
	{
		$oldUmask = umask(0); 

		$returnValue = $this->rmkdirNoUmask($path, $mode);
		
		umask($oldUmask);
		
		return $returnValue;
	}

	function rmkdirNoUmask($path, $mode = 0777)
	{
		$path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
		$e = explode("/", ltrim($path, "/"));
		if (substr($path, 0, 1) == "/") {
			$e[0] = "/" . $e[0];
		}
		$c = count($e);
		$cp = $e[0];
		for ($i = 1; $i < $c; $i++) {
			if (!is_dir($cp) && !@mkdir($cp, $mode)) {
				return false;
			}
			$cp .= "/" . $e[$i];
		}
		if (is_dir($path)) {
			return true;
		}
		return @mkdir($path, $mode);
	}

	function getCurrentEvent() {
		if ($this->event != NULL) {
			return $this->event;
		}
		
		$this->em = $this->get('doctrine.orm.entity_manager');
		
		$query = $this->em->createQuery('SELECT e FROM NickyDigital\PhotoboothBundle\Entity\PhotoEvent e WHERE e.current=true');
		$events = $query->getResult();

		if (count($events) > 0) {
			return $events[0];
		}
		
		$event = new PhotoEvent;
		$event->setEventCode('default');
		$event->setEventName('Default');
		
		$this->event = $event;

		return $event;
	}
}
