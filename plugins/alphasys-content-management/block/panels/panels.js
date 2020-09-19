"use strict";

console.log('ASCM Panels');

var ascm_panels_available = (typeof ascm_panels_param['ascm-panels-available'] != 'undefined') ? ascm_panels_param['ascm-panels-available'] : [];
console.log(ascm_panels_available);
ascm_panels_available.forEach(function(entry) {
  
  var ascm_panel_title = (typeof entry['post_title'] != 'undefined') ? entry['post_title'] : 'No Titile';
  var ascm_panel_id = (typeof entry['ID'] != 'undefined') ? entry['ID'] : '';
  var ascm_panel_name = (typeof entry['post_name'] != 'undefined') ? entry['post_name'] : '';

  if (ascm_panel_id != '' && ascm_panel_id != null && 
    ascm_panel_name != '' && ascm_panel_name != null) {

    wp.blocks.registerBlockType('ascm-panels/shortcode-panels-'+ascm_panel_id, {
      title: ascm_panel_title,
      icon: 'tagcloud',
      category: 'ascm-panels-block-category',
      attributes: {
        ascm_shortcode_panel: {type: 'string'},
      },
      edit: function(props) {
        function updateascmShortcodepanel(event) {
          props.setAttributes({ascm_shortcode_panel: event.target.value})
        }

        return '[ascm-panels id='+ascm_panel_id+']';
      },
      save: function(props) {
        return '[ascm-panels id='+ascm_panel_id+']';
      }
    });

  }

});




// wp.blocks.registerBlockType('brad/border-box', {
//   title: 'My Cool Border Box',
//   icon: 'smiley',
//   category: 'common',
//   attributes: {
//     content: {type: 'string'},
//     color: {type: 'string'}
//   },
//   edit: function(props) {
//     function updateContent(event) {
//       props.setAttributes({content: event.target.value})
//     }

//     function updateColor(value) {
//       props.setAttributes({color: value.hex})
//     }

//     return wp.element.createElement(
//       "div",
//       null,
//       wp.element.createElement(
//         "h3",
//         null,
//         "Your Cool Border Box"
//       ),
//       wp.element.createElement("input", { type: "text", value: props.attributes.content, onChange: updateContent }),
//       wp.element.createElement(wp.components.ColorPicker, { color: props.attributes.color, onChangeComplete: updateColor })
//     );
//   },
//   save: function(props) {
//     return wp.element.createElement(
//       "h3",
//       { style: { border: "5px solid " + props.attributes.color } },
//       props.attributes.content
//     );
//   }
// })



