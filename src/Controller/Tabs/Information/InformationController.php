<?php

namespace App\Controller\Tabs\Information;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ApInformationFilesRepository;


/**
 * @Route("/information", name="information_")
 */

class InformationController extends AbstractController
{

   /**
   * @Route("/", name="index")
   */
  public function index (ApInformationFilesRepository $apInformationFilesRepository): Response
  {
    $recentRhFiles = $apInformationFilesRepository->findRecentRhFiles();
    $recentQseFiles = $apInformationFilesRepository->findRecentQseFiles();
    $lastRhFile = $apInformationFilesRepository->findLastRhFiles();
    $lastQseFile = $apInformationFilesRepository->findLastQseFiles();

    return $this->render('tabs/information/index.html.twig', [
      'rh_files' => $recentRhFiles,
      'qse_files' => $recentQseFiles,
      'rh_file' => $lastRhFile,
      'qse_file' => $lastQseFile
  ]);
  }
}