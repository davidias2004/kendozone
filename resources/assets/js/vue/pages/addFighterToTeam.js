let VueDragula = require('../vue-dragula');

Vue.config.debug = true;

Vue.use(VueDragula);

vm = new Vue({
    el: '#dragula_top',
    data: {
        colOne: [],
        colTwo: [],

        teamsArea: [],
        team_id: 0,
        teams: [],
        competitorsArea: arrChampionshipsWithTeamsAndCompetitors,
        tournament: arrChampionshipsWithTeamsAndCompetitors,
        copyOne: [],
    },
    created: function () {
        Vue.vueDragula.options('', {
            copy: false
        })
    },
    mounted: function () {
        this.$nextTick(function () {
            let _this = this;
            $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
                jqXHR.setRequestHeader('X-CSRF-Token', csrfToken);
            });
            Vue.vueDragula.eventBus.$on(
                'drop',
                function (args) {
                    let championshipId = args[1].parentNode.getAttribute("championship-id");
                    let teamId = args[1].parentNode.getAttribute("team-id");
                    let competitorId = args[1].getAttribute("id");

                    $.post(url_root_api + "/teams/" + teamId + "/competitors/" + competitorId + "/add", function () {
                    })
                        .done(function () {

                        })
                        .fail(function () {

                        })
                        .always(function () {

                        });

                }
            );
            Vue.vueDragula.eventBus.$on(
                'dropModel',
                function (args) {
                    console.log('dropModel: ' + JSON.stringify(args));


                }
            )
        })
    },
    methods: {}
});