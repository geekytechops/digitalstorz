(function($) {
    "use strict";

    // Define AdvancedForm constructor
    function AdvancedForm() {}

    // Initialize the AdvancedForm functionality
    AdvancedForm.prototype.init = function() {
        // Initialize select2 plugins
        this.initializeSelect2();
        // Initialize tags input functionality
        this.initializeTagsInput();
        // Initialize MetisMenu for sidebar
        this.initializeMetisMenu();
    };

    // Select2 initialization
    AdvancedForm.prototype.initializeSelect2 = function() {
        // Basic select2 initialization
        $("#defectSelect , #adv_payment_mode").select2({
            placeholder: "Select up to 4 defects",
            maximumSelectionLength: 4,
            allowClear: true
        });

        $(".select2-limiting").select2({
            maximumSelectionLength: 2
        });

        $(".select2-search-disable").select2({
            minimumResultsForSearch: Infinity
        });

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
                var $container = $("<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
                    "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__title'></div>" +
                    "<div class='select2-result-repository__description'></div>" +
                    "<div class='select2-result-repository__statistics'>" +
                    "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
                    "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
                    "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
                    "</div></div></div>");
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

        $(".select2-templating").select2({
            templateResult: function(state) {
                if (!state.id) return state.text;
                var $state = $('<span><img src="/assets/images/flags/select2/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>');
                return $state;
            }
        });
    };

    // Tags input initialization
    AdvancedForm.prototype.initializeTagsInput = function() {
        const input = document.getElementById('tags-input');

        if (!input) {
            // Exit the function if the 'tags-input' field is not present
            return;
        }

        const wrapper = input.parentElement;
        let tagsArray = [];
        let editTagElement = null;

        input.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.key === ',') {
                event.preventDefault();
                const value = input.value.trim();
                if (value) {
                    if (editTagElement) {
                        const oldValue = editTagElement.firstChild.nodeValue;
                        const newValue = value.replace(/,$/, '');
                        editTagElement.firstChild.nodeValue = newValue;
                        updateTagInArray(oldValue, newValue);
                        editTagElement = null;
                    } else {
                        addTag(value);
                    }
                    input.value = '';
                }
            }
        });

        function addTag(tag) {
            const span = document.createElement('span');
            span.className = 'tag';
            const sanitizedTag = tag.replace(/,$/, '');
            span.innerText = sanitizedTag;
            tagsArray.push(sanitizedTag);

            const removeBtn = document.createElement('span');
            removeBtn.className = 'remove-tag';
            removeBtn.innerHTML = '&times;';
            removeBtn.onclick = function() {
                wrapper.removeChild(span);
                removeTagFromArray(sanitizedTag);
                if (editTagElement === span) {
                    editTagElement = null;
                    input.value = '';
                }
            };

            span.appendChild(removeBtn);
            span.onclick = function() {
                input.value = sanitizedTag;
                editTagElement = span;
            };

            wrapper.insertBefore(span, input);
            console.log('Current Tags:', tagsArray);
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
    };

    // MetisMenu initialization
    AdvancedForm.prototype.initializeMetisMenu = function() {
        // Initialize metismenu for sidebar menus
        $('#side-menu').metisMenu();

        // Adjust sidebar on window resize
        $(window).on("resize", function() {
            if ($(window).width() < 768) {
                $('#side-menu').removeClass('in');
            } else {
                $('#side-menu').addClass('in');
            }
        });
    };

    $.AdvancedForm = new AdvancedForm();
    $.AdvancedForm.Constructor = AdvancedForm;
    
    // Define CalendarPage constructor
    function CalendarPage() {}

    // Initialize CalendarPage functionality
    CalendarPage.prototype.init = function() {
        var l = $("#event-modal"),
            t = $("#modal-title"),
            a = $("#form-event"),
            i = null,
            r = null,
            s = document.getElementsByClassName("needs-validation"),
            e = new Date(),
            n = e.getDate(),
            d = e.getMonth(),
            o = e.getFullYear();

        var c = []; // Example events are commented out

        var v = document.getElementById("calendar");

        function u(e) {
            l.modal("show"),
            a.removeClass("was-validated"),
            a[0].reset(),
            $("#event-title").val(),
            $("#event-category").val(),
            t.text("Add Event"),
            r = e;
        }

        var m = new FullCalendar.Calendar(v, {
            plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
            editable: true,
            droppable: true,
            selectable: true,
            defaultView: "dayGridMonth",
            themeSystem: "bootstrap",
            header: { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth" },
            eventClick: function(e) {
                l.modal("show"),
                a[0].reset(),
                i = e.event,
                $("#event-title").val(i.title),
                $("#event-category").val(i.classNames[0]),
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

        $(a).on("submit", function(e) {
            e.preventDefault();
            var t, a = $("#event-title").val(),
                n = $("#event-category").val();
            if (!s[0].checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                s[0].classList.add("was-validated");
            } else {
                i ? (i.setProp("title", a), i.setProp("classNames", [n])) : (t = { title: a, start: r.date, allDay: r.allDay, className: n }, m.addEvent(t)), l.modal("hide");
            }
        });

        $("#btn-delete-event").on("click", function(e) {
            i && (i.remove(), i = null, l.modal("hide"));
        });

        $("#btn-new-event").on("click", function(e) {
            u({ date: new Date(), allDay: true });
        });
    };

    $.CalendarPage = new CalendarPage();
    $.CalendarPage.Constructor = CalendarPage;
    
    // Initialize the form and calendar
    $(function() {
        $.AdvancedForm.init();
        $.CalendarPage.init();
    });

})(jQuery);
