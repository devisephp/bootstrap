<?php namespace Devise\Pages;

use Illuminate\Routing\Redirector;
use Response;

/**
 * Response handler takes care of creating,updating, destroying
 * and copying pages within the /admin/pages routes
 */
class PageResponseHandler
{
    /**
     * PageManager manages pages
     *
     * @var PageManager
     */
    private $PageManager;

    /**
     * PagesRepository fetches pages
     *
     * @var PagesRepository
     */
    private $PagesRepository;

    /**
     * Redirector is used to redirect traffic
     *
     * @var Illuminate\Routing\Redirector
     */
    private $Redirect;

    /**
     * PageVersionManager manages page versions
     *
     * @var PageVersionManager
     */
    private $PageVersionManager;

    /**
     * Construct a new PageResponseHandler
     *
     * @param PageManager        $PageManager
     * @param PagesRepository    $PagesRepository
     * @param PageVersionManager $PageVersionManager
     * @param Redirector         $Redirect
     */
    public function __construct(PageManager $PageManager, PagesRepository $PagesRepository, PageVersionManager $PageVersionManager, Redirector $Redirect)
    {
        $this->PageManager = $PageManager;
        $this->PagesRepository = $PagesRepository;
        $this->Redirect = $Redirect;
        $this->PageVersionManager = $PageVersionManager;
    }

    /**
     * Request a new page be created
     *
     * @param  array $input
     * @return Redirector
     */
    public function requestCreateNewPage($input)
    {
        $page = $this->PageManager->createNewPage($input);

        if ($page)
        {
            return $this->Redirect->route('dvs-pages')
                ->with('warnings', $this->PageManager->warnings)
                ->with('message', $this->PageManager->message);
        }

        return $this->Redirect->route('dvs-pages-create')
            ->withInput()
            ->withErrors($this->PageManager->errors)
            ->with('message', $this->PageManager->message);
    }

    /**
     * Request page be updated with given input
     *
     * @param  integer $id
     * @param  array   $input
     * @return Redirector
     */
    public function requestUpdatePage($id, $input)
    {
        $page = $this->PageManager->updatePage($id, $input);

        if ($page)
        {
            return $this->Redirect->route('dvs-pages')
                ->with('warnings', $this->PageManager->warnings)
                ->with('message', $this->PageManager->message);
        }

        return $this->Redirect->route('dvs-pages-edit', $id)
            ->withInput()
            ->withErrors($this->PageManager->errors)
            ->with('message', $this->PageManager->message);
    }

    /**
     * Request the page be deleted from database
     *
     * @param  integer $id
     * @return Redirector
     */
    public function requestDestroyPage($id)
    {
        $page = $this->PageManager->destroyPage($id);

        if ($page)
        {
            return $this->Redirect->route('dvs-pages')
                ->with('warnings', $this->PageManager->warnings)
                ->with('message', $this->PageManager->message);
        }

        return $this->Redirect->route('dvs-pages')
            ->withInput()
            ->withErrors($this->PageManager->errors)
            ->with('message', $this->PageManager->message);
    }

    /**
     * Request the page be copied to another page (duplicated)
     *
     * @param  integer $id
     * @param  array   $input
     * @return Redirector
     */
    public function requestCopyPage($id, $input)
    {
        $page = $this->PageManager->copyPage($id, $input);

        if ($page)
        {
            return $this->Redirect->route('dvs-pages')
                ->with('warnings', $this->PageManager->warnings)
                ->with('message', $this->PageManager->message);
        }

        return $this->Redirect->route('dvs-pages-copy', $id)
            ->withInput()
            ->withErrors($this->PageManager->errors)
            ->with('message', $this->PageManager->message);
    }

    /**
     * Request page version be stored
     *
     * @param  array $input
     * @return PageVersion
     */
    public function requestStorePageVersion($input)
    {
        return $this->PageVersionManager->copyPageVersion($input['page_version_id'], $input['name']);
    }

    /**
     * Request page version be destroyed
     *
     * @param  integer $pageVersionId
     * @return Response || Redirect
     */
    public function requestDestroyPageVersion($pageVersionId) {
        if($this->PageVersionManager->destroyPageVersion($pageVersionId)) {
            return Response::json([
                    'message' => 'Page Version successfully removed',
                    'data' => $pageVersionId
                ],
                200
            );

        } else {
            return Response::json([
                    'message' => 'The Page Version could not be removed. Please try again or contact an administrator',
                ],
                500
            );
        }
    }

    /**
     * Request the page listing
     *
     * @return EloquentCollection
     */
    public function requestPageList($input)
    {
        $term = array_get($input, 'term');
        $includeAdmin = array_get($input, 'includeAdmin') == '1' ? true : false;

        return $this->PagesRepository->getPagesList($includeAdmin, $term);
    }

    /**
     * Request a page version be updated
     *
     * @param  integer $pageVersionId
     * @param  array   $input
     * @return string
     */
    public function requestUpdatePageVersionDates($pageVersionId, $input)
    {
        $this->PageManager->updatePageVersionDates($pageVersionId, $input);

        return '';
    }

    /**
     * Request that the page version sharing be toggled
     *
     * @param  integer $pageVersionId
     * @return Response::json
     */
    public function requestTogglePageVersionShare($pageVersionId)
    {
        $this->PageVersionManager->togglePageVersionPreviewShare($pageVersionId);

        return \Response::json([
                'message' => 'Page version\'s share status successfully updated',
                'data' => $pageVersionId
            ],
            200
        );
    }

    /**
     * Request that ab testing be turned on or off
     *
     * @param  [type] $input
     * @return [type]
     */
    public function requestToggleAbTesting($input)
    {
        $pageId = $input['pageId'];
        $enabled = $input['enabled'];
        $this->PageManager->toggleABTesting($pageId, $enabled);

        return '';
    }

    /**
     * Updates the page version's ab testing percentage
     * amount. This percentage is the chance it will be picked
     * during the dice roll for A|B testing
     *
     * @param  [type] $input
     * @return [type]
     */
    public function requestUpdatePageVersionAbTesting($input)
    {
        $pageVersionId = $input['pageVersionId'];
        $amount = $input['amount'];
        $this->PageManager->updatePageVersionABTestingAmount($pageVersionId, $amount);

        return '';
    }

    /**
     * Updates the page version's view. This can override the main
     * page's view if there is one selected.
     *
     * @param  [type] $pageVersionId
     * @param  [type] $input
     * @return [type]
     */
    public function requestUpdatePageVersionTemplate($pageVersionId, $input)
    {
        $view = $input['view'];
        $this->PageManager->updatePageVersionView($pageVersionId, $view);
    }
}