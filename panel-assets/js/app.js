(function($) {
    "use strict";
    
    function e() {}
    
    e.prototype.init = function() {
        // Initialize basic select2
        $(".select2").select2();

        // Select2 with limiting selection
        $(".select2-limiting").select2({
            maximumSelectionLength: 2
        });

        // Select2 with search disabled
        $(".select2-search-disable").select2({
            minimumResultsForSearch: Infinity
        });

        // Select2 with AJAX loading
        $(".select2-ajax").select2({
            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: "Search for a repository",
            minimumInputLength: 1,
            templateResult: function(repo) {
                if (repo.loading) return repo.text;

                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                        "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
                        "<div class='select2-result-repository__meta'>" +
                            "<div class='select2-result-repository__title'></div>" +
                            "<div class='select2-result-repository__description'></div>" +
                            "<div class='select2-result-repository__statistics'>" +
                                "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
                                "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
                                "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
                            "</div>" +
                        "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-repository__title").text(repo.full_name);
                $container.find(".select2-result-repository__description").text(repo.description);
                $container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
                $container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
                $container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");

                return $container;
            },
            templateSelection: function(repo) {
                return repo.full_name || repo.text;
            }
        });

        // Select2 with templating
        $(".select2-templating").select2({
            templateResult: function(state) {
                if (!state.id) return state.text;
                var $state = $(
                    '<span><img src="/assets/images/flags/select2/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
                );
                return $state;
            }
        });
    };
    
    $.AdvancedForm = new e();
    $.AdvancedForm.Constructor = e;
})(window.jQuery);

// Initialize the form
(function() {
    "use strict";
    window.jQuery.AdvancedForm.init();
})();
