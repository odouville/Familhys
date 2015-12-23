$(function () {
    // Ajout du "bouton à cocher" d'activité à tous les conteneurs prévus (plusieurs conteneurs spécifiques pour être responsive)
    $('.act-chkbtn-container').each(function () {
        var $container = $(this),
            classes = 'chkbtn act-chkbtn btn btn-xs';
        if (!$container.hasClass('inline')) classes += ' btn-block';
        $container.append('<button type="button" class="' + classes + '" data-target="#act-cantine">Cantine</button>');
        $container.append('<button type="button" class="' + classes + '" data-target="#act-garderie">Garderie</button>');
        $container.append('<button type="button" class="' + classes + '" data-target="#act-coucou0">Coucou 0</button>');
        $container.append('<button type="button" class="' + classes + '" data-target="#act-coucou1">Coucou 1</button>');
        $container.append('<button type="button" class="' + classes + '" data-target="#act-coucou2">Coucou 2</button>');
        $container.append('<button type="button" class="' + classes + '" data-target="#act-coucou3">Coucou 3</button>');
        $container.append('<button type="button" class="' + classes + '" data-target="#act-coucou4">Coucou 4</button>');
    });
    // Ajout du "bouton à cocher" d'inscrit à tous les conteneurs prévus (plusieurs conteneurs spécifiques pour être responsive)
    $('.ins-chkbtn-container').each(function () {
        var $container = $(this),
            classes = 'chkbtn ins-chkbtn btn btn-xs';
        if (!$container.hasClass('inline')) classes += ' btn-block';
        $container.append('<button type="button" class="' + classes + '" data-target="#ins-antoine">Antoine</button>');
        $container.append('<button type="button" class="' + classes + '" data-target="#ins-jules">Jules</button>');
        $container.append('<button type="button" class="' + classes + '" data-target="#ins-louis">Louis</button>');
    });
});

$(function () {
    $('.act-chkbtn,.ins-chkbtn').each(function () {

        // Settings
        var $button = $(this),
            $checkbox = $($button.data('target')),
            color = $checkbox.data('color-class'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass(color + ' active');
            }
            else {
                $button
                    .removeClass(color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});
