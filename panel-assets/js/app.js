(function($) {
    "use strict";
    
    function e() {}
    
    e.prototype.init = function() {
        // Initialize basic select2
        // $(".select2").select2();
        $("#defectSelect").select2({
            placeholder: "Select up to 4 defects",
            maximumSelectionLength: 4,
            allowClear: true
        });

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
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('tags-input');
    const wrapper = input.parentElement;
    let tagsArray = []; // Array to hold the tags
    let editTagElement = null; // To keep track of the tag being edited

    input.addEventListener('keydown', function(event) {
        if (event.key === 'Enter' || event.key === ',') {
            event.preventDefault();
            const value = input.value.trim();
            if (value) {
                if (editTagElement) {
                    // Update the existing tag
                    const oldValue = editTagElement.firstChild.nodeValue;
                    const newValue = value.replace(/,$/, '');
                    editTagElement.firstChild.nodeValue = newValue;
                    updateTagInArray(oldValue, newValue);
                    editTagElement = null;
                } else {
                    // Add a new tag
                    addTag(value);
                }
                input.value = '';
            }
        }
    });

    function addTag(tag) {
        const span = document.createElement('span');
        span.className = 'tag';
        const sanitizedTag = tag.replace(/,$/, ''); // Remove trailing comma if present
        span.innerText = sanitizedTag;
        tagsArray.push(sanitizedTag); // Add tag to the array

        const removeBtn = document.createElement('span');
        removeBtn.className = 'remove-tag';
        removeBtn.innerHTML = '&times;';
        removeBtn.onclick = function() {
            wrapper.removeChild(span);
            removeTagFromArray(sanitizedTag); // Remove tag from the array
            // If the tag being removed is the one being edited, clear the editTagElement
            if (editTagElement === span) {
                editTagElement = null;
                input.value = '';
            }
        };

        span.appendChild(removeBtn);

        // Set up click event to edit the tag
        span.onclick = function() {
            input.value = sanitizedTag; // Set input field with the tag's text
            editTagElement = span; // Track the tag being edited
        };

        wrapper.insertBefore(span, input);
        console.log('Current Tags:', tagsArray); // Log current tags array
        $('#tags-input-values').val(JSON.stringify(tagsArray));
    }

    function removeTagFromArray(tag) {
        tagsArray = tagsArray.filter(t => t !== tag);
        console.log('Updated Tags after removal:', tagsArray);
    }

    function updateTagInArray(oldTag, newTag) {
        const index = tagsArray.indexOf(oldTag);
        if (index !== -1) {
            tagsArray[index] = newTag;
            console.log('Updated Tags after editing:', tagsArray);
        }
    }
});


!function(g) {
    "use strict";
    function e() {}
    e.prototype.init = function() {
        var l = g("#event-modal"),
            t = g("#modal-title"),
            a = g("#form-event"),
            i = null,
            r = null,
            s = document.getElementsByClassName("needs-validation"),
            e = new Date,
            n = e.getDate(),
            d = e.getMonth(),
            o = e.getFullYear();

        var c = [
            // { title: "All Day Event", start: new Date(o, d, 1) },
            // { title: "Long Event", start: new Date(o, d, n - 5), end: new Date(o, d, n - 2), className: "bg-warning" },
            // { id: 999, title: "Repeating Event", start: new Date(o, d, n - 3, 16, 0), allDay: !1, className: "bg-info" },
            // { id: 999, title: "Repeating Event", start: new Date(o, d, n + 4, 16, 0), allDay: !1, className: "bg-primary" },
            // { title: "Meeting", start: new Date(o, d, n, 10, 30), allDay: !1, className: "bg-success" },
            // { title: "Lunch", start: new Date(o, d, n, 12, 0), end: new Date(o, d, n, 14, 0), allDay: !1, className: "bg-danger" },
            // { title: "Birthday Party", start: new Date(o, d, n + 1, 19, 0), end: new Date(o, d, n + 1, 22, 30), allDay: !1, className: "bg-success" },
            // { title: "Click for Google", start: new Date(o, d, 28), end: new Date(o, d, 29), url: "http://google.com/", className: "bg-dark" }
        ];

        var v = document.getElementById("calendar");

        function u(e) {
            l.modal("show"),
            a.removeClass("was-validated"),
            a[0].reset(),
            g("#event-title").val(),
            g("#event-category").val(),
            t.text("Add Event"),
            r = e;
        }

        var m = new FullCalendar.Calendar(v, {
            plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
            editable: !0,
            droppable: !0,
            selectable: !0,
            defaultView: "dayGridMonth",
            themeSystem: "bootstrap",
            header: { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth" },
            eventClick: function(e) {
                l.modal("show"),
                a[0].reset(),
                i = e.event,
                g("#event-title").val(i.title),
                g("#event-category").val(i.classNames[0]),
                r = null,
                t.text("Edit Event"),
                r = null;
            },
            dateClick: function(e) {
                var selectedDate = e.dateStr; // Format: YYYY-MM-DD
                window.location.href = "mark-attendance.php?date=" + selectedDate;
            },
            events: c
        });

        m.render();

        g(a).on("submit", function(e) {
            e.preventDefault();
            var t, a = g("#event-title").val(),
                n = g("#event-category").val();
            !1 === s[0].checkValidity() ? (event.preventDefault(), event.stopPropagation(), s[0].classList.add("was-validated")) : (i ? (i.setProp("title", a), i.setProp("classNames", [n])) : (t = { title: a, start: r.date, allDay: r.allDay, className: n }, m.addEvent(t)), l.modal("hide"));
        });

        g("#btn-delete-event").on("click", function(e) {
            i && (i.remove(), i = null, l.modal("hide"));
        });

        g("#btn-new-event").on("click", function(e) {
            u({ date: new Date, allDay: !0 });
        });
    };

    g.CalendarPage = new e,
    g.CalendarPage.Constructor = e;
}(window.jQuery), function() {
    "use strict";
    window.jQuery.CalendarPage.init();
}();
