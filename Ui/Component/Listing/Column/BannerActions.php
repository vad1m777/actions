<?php
namespace Malesh\Banner\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class BannerActions extends Column
{
/**
* @var UrlInterface
*/
    const BANNER_URL_PATH_EDIT = 'malesh/banner/edit';
    const BANNER_URL_PATH_DELETE = 'malesh/banner/delete';

    protected $urlBuilder;
    private $editUrl;

/**
* @param ContextInterface $context
* @param UiComponentFactory $uiComponentFactory
* @param UrlInterface $urlBuilder
* @param array $components
* @param array $data
*/
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::BANNER_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

/**
* Prepare Data Source
*
* @param array $dataSource
* @return array
*/
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::BANNER_URL_PATH_DELETE, ['id' => $item['id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete banner'),
                            'message' => __('
                                Are you sure you wan\'t to delete a banner "${ $.$data.name }" for category "${ $.$data.category_name }" ?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}