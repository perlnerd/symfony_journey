<?php
namespace AppBundle\Controller;

use AppBundle\Entity\UserAuth as User;
use AppBundle\Entity\Journey;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Form\AdminSearchType;

class DefaultController extends Controller
{
    private $eventHelper;
    private $params;
    private $sessionHelper;
    private $userId;

    public function __construct()
    {
    }

    /**
     * @param  Resource Symfony\Component\HttpFoundation\Request
     * @return Resource Symfony\Component\HttpFoundation\Response
     * @Route("/admin/search", name="admin_search")
     */
    public function adminSearchAction(Request $request)
    {
        $this->checkAuth();
        $this->configureHelpers();
        $this->configureAuthUser();

        $journey = new Journey();
        
        $form = $this->createForm(new AdminSearchType(), $journey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email         = $form->get('email')->getData();
            $resultList    = $this->eventHelper->fetchReportByEmail($email);
            $eventTypeList = $this->eventHelper->getValidEventTypeList();

            foreach ($resultList as $value) {
                $mappedResultList[] = array('eventType' => $eventTypeList[$value['event_type']], 'date' => $value['event_time']);
            }
        }

        return $this->render('admin/search.html.twig', array('form' => $form->createView(), 'result' => $mappedResultList, 'email' => $email));
    }

    /**
     * @param  Resource Symfony\Component\HttpFoundation\Request
     * @return Resource Symfony\Component\HttpFoundation\Response
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        $this->checkAuth();
        $this->configureHelpers();
        $this->configureAuthUser();
        
        $journey = new Journey();
        $form    = $this->createForm(new AdminSearchType(), $journey);
        $today   = date('Y-m-d');

        $resultList    = $this->eventHelper->fetchSummaryReportByDate($today);
        $eventTypeList = $this->eventHelper->getValidEventTypeList();

        foreach ($resultList as $value) {
            $mappedResultList[] = array('eventType' => $eventTypeList[$value['eventType']], 'total' => $value[1]);
        }

        return $this->render('admin/index.html.twig', array('result' => $mappedResultList, 'date' => $today, 'form' => $form->createView()));
    }

    /**
     * @param  Resource Symfony\Component\HttpFoundation\Request
     * @return Resource Symfony\Component\HttpFoundation\Response
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $this->configureHelpers();
        $this->sessionHelper->configureAnonId();
        $this->configureUser();
        $this->eventHelper->logJourneyEvent(1, $this->userId);

        return $this->render('default/index.html.twig', $this->params);

    }

    /**
     * The learn page
     * @param  Resource Symfony\Component\HttpFoundation\Request
     * @return Resource Symfony\Component\HttpFoundation\Response
     * @Route("/learn", name="learn")
     */
    public function learnAction(Request $request)
    {
        $this->checkAuth();
        $this->configureHelpers();
        $this->configureAuthUser();
        $this->eventHelper->logJourneyEvent(3, $this->userId);

        return $this->render('learn/index.html.twig', $this->params);
    }

    /**
     * The test page
     * @param  Resource Symfony\Component\HttpFoundation\Request
     * @return Resource Symfony\Component\HttpFoundation\Response
     * @Route("/test", name="test")
     */
    public function testAction(Request $request)
    {
        $this->checkAuth();
        $this->configureHelpers();
        $this->configureAuthUser();

        if (false !== $request->query->get('complete', false)) {
            $this->eventHelper->logJourneyEvent('exam', $this->userId);
            $this->addFlash(
                'notice',
                '<h3>Congratuations!</h3><h4>Thank you for taking the test. We are pleased to inform you that you passed with flying colours.</h4>'
            );
            $this->eventHelper->logJourneyEvent('license', $this->userId);

            return $this->render('test/index.html.twig', $this->params);
        }

        $this->eventHelper->logJourneyEvent(4, $this->userId);

        return $this->render('test/index.html.twig', $this->params);
    }

    /**
     * The shop page
     * @param  Resource Symfony\Component\HttpFoundation\Request
     * @return Resource Symfony\Component\HttpFoundation\Response
     * @Route("/shop", name="shop")
     */
    public function shopAction(Request $request)
    {
        $this->configureHelpers();
        $this->sessionHelper->configureAnonId();
        $this->configureUser();
        $this->eventHelper->logJourneyEvent(2, $this->userId);

        return $this->render('shop/index.html.twig', $this->params);
    }

    private function fetchTwigParamList($user)
    {
        return array(
            'base_dir'  => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'emailAddress' => $user->getAuEmailAddress(),
        );
    }

    /**
     * fetch instances of the event and session helpers.
     * @return Object $this;
     */
    private function configureHelpers()
    {
        $this->eventHelper   = $this->get('app.event.logger');
        $this->sessionHelper = $this->get('app.session.helper')->startSession();

        return $this;
    }

    /**
     * configure user info on routes that can be accessed by both anonymous and authorized users.
     * @return Object $this;
     */
    private function configureUser()
    {
        $this->params = array();
        $this->userId = $this->sessionHelper->getAnonymousId();

        if ($userObj = $this->getUser()) {
            $this->params = $this->fetchTwigParamList($userObj);
            $this->userId = $userObj->getId();
        }

        return $this;
    }

    /**
     * configure user info for routes that require an authorized user.
     * @return Object $this
     */
    private function configureAuthUser()
    {
        $userObj      = $this->getUser();
        $this->params = $this->fetchTwigParamList($userObj);
        $this->userId = $userObj->getId();

        return $this;
    }

    /**
     * check if a user is fully authenticated
     * @return void
     */
    private function checkAuth()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
    }
}
