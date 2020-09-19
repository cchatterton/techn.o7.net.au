"use strict";

console.log('ASCM Repost');

var ascm_repost_list_type = (typeof ascm_repost_param['ascm-repost-list-type'] != 'undefined') ? ascm_repost_param['ascm-repost-list-type'] : [];

var result = Object.keys(ascm_repost_list_type).map(function(key) {
  var result_arr = {
    label: ascm_repost_list_type[key],
    value: key
  }
  return result_arr;
});

console.log(result);
result.forEach(function(entry) {
  console.log(entry);
  var ascm_repost_label = (typeof entry['label'] != 'undefined') ? entry['label'] : '';
  var ascm_repost_value = (typeof entry['value'] != 'undefined') ? entry['value'] : '';

  console.log(ascm_repost_label);
  console.log(ascm_repost_value);

  if (ascm_repost_label != '' && ascm_repost_label != null && 
    ascm_repost_value != '' && ascm_repost_value != null) {

    wp.blocks.registerBlockType('ascm-repost/shortcode-repost-'+ascm_repost_value, {
      title: ascm_repost_label,
      icon: 'welcome-widgets-menus',
      category: 'ascm-repost-block-category',
      attributes: {
        ascm_shortcode_repost: {type: 'string'},
      },
      edit: function(props) {
        function updateascmShortcoderepost(event) {
          props.setAttributes({ascm_shortcode_repost: event.target.value})
        }

        return '[ascm-repost lt='+ascm_repost_value+']';
      },
      save: function(props) {
        return '[ascm-repost lt='+ascm_repost_value+']';
      }
    });

  }

});