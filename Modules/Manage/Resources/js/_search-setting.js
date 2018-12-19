/**
 * Settings Search
 * -------------------------
 * Created by Negar Jamalifard
 * n.jamalifard@gmail.com
 * On 2018-08-14
 */


$(document).ready(function () {
    let resultView   = $('#setting_result_view');
    let categoryView = $('#setting_category_view');
    let store        = $('#setting_json_value');
    let alertMessage = store.attr('data-alert-message');
    let settings     = JSON.parse(JSON.parse(store.attr('data-value')));

    $('.search-setting-js').on('keyup', function () {
        let value = $(this).val().trim();
        reset();

        if (value.length) {
            showResult(searchArrayFor(value));
        }
    });


    /**
     * Searches setting array for result
     * @param key
     * @return {{}}
     */
    function searchArrayFor(key) {
        let result      = {};
        let finalResult = {};



        result['slug'] = settings.filter(function (setting) {
            return (new RegExp('^' + RegExp.escape(key)).test(setting.slug))
        });

        result['title'] = settings.filter(function (setting) {
            return (new RegExp('^' + RegExp.escape(key)).test(setting.title))
        });


        finalResult = result['slug'].concat(result['title'].filter(function (item) {
            return result['slug'].indexOf(item) < 0
        }));

        return finalResult;
    }


    /**
     * shows result with proper html element
     * @param results
     */
    function showResult(results) {
        let elements = "";

        if (results.length < 1) {
            elements = "<div role='alert' class='alert alert-warning'>" + alertMessage + "</div>"
        } else {
            elements = results.map(function (result) {
                //TODO: href should be updated
                return "<a class='list-group-item' style='border-width: 1px;' href='#/blabla/" + result.id + "'>" + result.title + "</a>";
            }).join(" ");
        }

        updateResult(elements);
    }


    /**
     * shows result container and hides categories
     * @param result
     */
    function updateResult(result) {
        resultView.empty().append(result).show();
        categoryView.hide();
    }


    /**
     * resets view
     */
    function reset() {
        resultView.empty().hide();
        categoryView.show();
    }


    /**
     * escape RegExp in string
     * @param s
     */
    RegExp.escape= function(s) {
        return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    };
});
