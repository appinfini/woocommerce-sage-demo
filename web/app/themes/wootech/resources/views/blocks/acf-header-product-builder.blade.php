{{--
  Title: Header Product Builder
  Description: A custom header product builder block.
  Category: formatting
  Icon: products
  Keywords: product header
  Mode: edit
  PostTypes: page
  SupportsMode: true
  SupportsMultiple: false
--}}

@include(
    'sections.acf-header-product-builder',
    [
        'layout' => [
            'section_configuration' => $block['data']['section_configuration']
        ],
        'meta' => [],
        'order' => 0
    ]
)
