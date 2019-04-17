<?php
namespace App\Controller;

use App\ApiClient\GitlabApiHttpClientScoped;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GitlabScopedController extends AbstractController
{
    private $gitlabApiHttpClientScoped;

    public function __construct(
        GitlabApiHttpClientScoped $gitlabApiHttpClientScoped
    ) {
        $this->gitlabApiHttpClientScoped = $gitlabApiHttpClientScoped;
    }

    /**
     * @Route("/gitlab-projects/")
     */
    public function projects(): Response
    {
        $projectData = $this->gitlabApiHttpClientScoped->getProjects();

        return $this->render('gitlab.html.twig', ['data' => $projectData]);
    }

    /**
     * @Route("/gitlab-projects/{id}")
     */
    public function project(int $id): Response
    {
        $projectData = $this->gitlabApiHttpClientScoped->getProject($id);

        return $this->render('gitlab.html.twig', ['data' => $projectData]);
    }

    /**
     * @Route("/gitlab-projects/{id}/members")
     */
    public function projectMembers(int $id): Response
    {
        $projectMembersData = $this->gitlabApiHttpClientScoped->getProjectMembers($id);

        return $this->render('gitlab.html.twig', ['data' => $projectMembersData]);
    }
}