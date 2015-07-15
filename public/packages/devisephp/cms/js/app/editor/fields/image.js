devise.define(['require', 'jquery', 'dvsSidebarView', 'ckeditorJquery'], function (require, $, sidebar) {

    // we pass the image and settings back from the
    // window opener. The target is the place we will
    // update, which is typically just image but could
    // be a thumbnail too
    function onMediaManagerSelect(parentForm, image, target, settings)
    {
        var selector = 'input[name="' + target + '"]';

        parentForm.find(selector).val(image);

        if (settings.crop)
        {
            parentForm.find('input[name="_crop_' + target + '"]').val(1);
            parentForm.find('input[name="' + target + '_width"]').val(settings.crop.width);
            parentForm.find('input[name="' + target + '_height"]').val(settings.crop.height);
            parentForm.find('input[name="' + target + '_crop_x"]').val(settings.crop.x);
            parentForm.find('input[name="' + target + '_crop_y"]').val(settings.crop.y);
            parentForm.find('input[name="' + target + '_crop_x2"]').val(settings.crop.x2);
            parentForm.find('input[name="' + target + '_crop_y2"]').val(settings.crop.y2);
            parentForm.find('input[name="' + target + '_crop_w"]').val(settings.crop.w);
            parentForm.find('input[name="' + target + '_crop_h"]').val(settings.crop.h);

            parentForm.find('input[name="_crop_' + target + '"]').trigger('change');
            parentForm.find('input[name="' + target + '_width"]').trigger('change');
            parentForm.find('input[name="' + target + '_height"]').trigger('change');
            parentForm.find('input[name="' + target + '_crop_x"]').trigger('change');
            parentForm.find('input[name="' + target + '_crop_y"]').trigger('change');
            parentForm.find('input[name="' + target + '_crop_x2"]').trigger('change');
            parentForm.find('input[name="' + target + '_crop_y2"]').trigger('change');
            parentForm.find('input[name="' + target + '_crop_w"]').trigger('change');
            parentForm.find('input[name="' + target + '_crop_h"]').trigger('change');
        }

        // make sure to trigger the change on this input
        // in case we have any events tied to that element
        parentForm.find(selector).trigger('input');
        parentForm.find(selector).trigger('propertychange');
    }

    return {
        init: function(url)
        {
            //
            // opens the media manager
            // so we can select a new image
            //
            $('.browse').click(function(e)
            {
                var parentForm = $(this).parents('form');
                var target = $(e.currentTarget).data('target');
                var mediaUrl = url + '?type=image&cropMode=Preserve&target=' + target + '&open-last-category';

                document.onMediaManagerSelect = function(image, target, settings) { onMediaManagerSelect(parentForm, image, target, settings); }
                window.open(mediaUrl, 'Media Manager', "width=1024,height=768,location=no");
            });

            //
            // opens the cropper tool in a new window
            //
            $('.js-crop').click(function(e)
            {
                var parentForm = $(this).parents('form');
                var target = $(e.currentTarget).data('target');
                var imageWidth = $(e.currentTarget).data('imageWidth');
                var imageHeight = $(e.currentTarget).data('imageHeight');
                var imagePath = parentForm.find('[name="image"]').val();
                var mediaUrl = url + '/crop?type=image&cropMode=Tool&target=' + target + '&image=' + imagePath;

                if (imageWidth)
                    mediaUrl += '&width=' + imageWidth;

                if (imageHeight)
                    mediaUrl += '&height=' + imageHeight;

                if (imagePath == '')
                    return;

                document.onMediaManagerSelect = function(image, target, settings) { onMediaManagerSelect(parentForm, image, target, settings); }
                window.open(mediaUrl, 'Media Manager', "width=1024,height=768,location=no");
            });

            // disable the 'adjust thumbnail' btn  when this is not clicked
            $('[for="has_thumbnail"]').on('click', function()
            {
                $('.js-when-has-thumbnail').attr('disabled', $('input[name="has_thumbnail"]').is(':checked'));
            });
        }
    };
});