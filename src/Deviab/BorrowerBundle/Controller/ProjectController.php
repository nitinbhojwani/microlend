<?php
/**
 * Created by PhpStorm.
 * User: dk-jarvis
 * Date: 19/09/15
 * Time: 9:58 AM
 */

namespace Deviab\BorrowerBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\Serializer\SerializationContext;

class ProjectController extends Controller
{
    public function getProjectAction( $projectId )
    {
        $projectService = $this->container->get('project_service');
        $projectStatus = $projectService->getProjectStatus($projectId);
        return $projectStatus;
    }

    /**
     * @param $projectId
     * @return mixed
     */
    public function getFeaturedProjectAction( $projectId )
    {
        $projectService = $this->container->get('project_service');
        $projectStatus = $projectService->getFeaturedProject($projectId);
        return $projectStatus;
    }

    public function payuSuccessWebhookAction( Request $request )
    {
        $investmentService = $this->container->get('project_service');
        $response = $investmentService->capturePayUTransaction($request);
        return $response;
    }
}