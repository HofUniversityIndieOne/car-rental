<?php
namespace HofUniversityIndie\CarRental\Controller;

use HofUniversityIndie\CarRental\Domain\Repository\CarRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/***
 * This file is part of the "Car Rental" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 ***/

class JsonController extends ActionController
{
    /**
     * @var CarRepository
     */
    private $carRepository = null;

    /**
     * @var string
     */
    protected $defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;

    public function injectCarRepository(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function listAction()
    {
        $cars = $this->carRepository->findAll();
        /** @var \TYPO3\CMS\Extbase\Mvc\View\JsonView $view */
        $view = $this->view;
        $view->assign('cars', $cars->toArray());
        $view->setVariablesToRender(['cars']);
        $view->setConfiguration([
            'cars' => [
                '_descendAll' => [
                    '_exclude' => ['pid'],
                    '_descend' => [
                        'brand' => [
                            '_exclude' => ['pid'],
                        ],
                        'tires' => [
                            '_descendAll' => [
                                '_exclude' => ['pid'],
                            ],
                        ]
                    ]
                ]
            ],
        ]);
    }
}
