{{--
  Title: Image and Content Builder
  Description: A custom image and content builder block.
  Category: formatting
  Icon: admin-comments
  Keywords: testimonial quote
  Mode: edit
  PostTypes: page
  SupportsMode: true
  SupportsMultiple: true
--}}

@include(
    'sections.acf-image-and-content-builder',
    [
        'layout' => [
            'section_configuration' => $block['data']['section_configuration']
        ],
        'meta' => [
            'source' => 'blocks'
        ],
        'order' => 0
    ]
)
