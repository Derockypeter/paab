<template>
    <div>
        <mobile-nav-component />
        <!-- Sidebar for large and medium devices -->
        <div class="row" id="dashRowDiv">
            <sidenav-component @user="getUser" />

            <div class="col s12 m10 l10">
                <div class="dashRightDiv">
                    <div id="superAdminDashRightImgDiv">
                        <div class="dashRightImgInnerDiv">
                            <div class="dashRightImgTxtDiv">
                                <p class="dashRightImgTitle">
                                    Lead your team and manage your clients
                                </p>
                                <p class="dashRightImgTxt">
                                    Say hello to the next level platform that
                                    gives you infinite freedom to create, design
                                    and manage your personal brand exactly the
                                    way you want.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="dashWlcNoteRowDiv">
                        <div class="col s12 m8 l8">
                            <div class="dashWlcNoteDiv">
                                <div class="dashWlcNoteInnerDiv">
                                    <p class="dashWlcNoteTitle">
                                        Welcome!
                                        <span class="dashWlcNoteTitle1"
                                            >{{ user.firstname }}
                                            {{ user.lastname }}</span
                                        >
                                    </p>
                                    <p class="dashWlcNoteTxt">
                                        Lets start and automate your process so
                                        you can reclaim time and focus on your
                                        goals.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col s12 m4 l4">
                            <div class="row">
                                <div class="dashTimeDiv">
                                    <div class="col s7 m6 l6">
                                        <div class="dashTimeInnerDiv">
                                            <p class="dashTimeDate">
                                                {{ currentMonth }}
                                                {{ currentDay }},
                                                {{ currentYear }}
                                            </p>
                                            <p class="dashTime">
                                                {{ currentTime
                                                }}<span
                                                    class="dashTimePeriod"
                                                    >{{ currentMidNoon }}</span
                                                >
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col s5 m6 l6">
                                        <div class="shapeDegDiv">
                                            <div class="shapeDeg"></div>
                                            <div class="shapeDeg1"></div>
                                            <div class="shapeDeg2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="myWebDiv">
                        <div class="col s12 m6 l6">
                            <div class="cardDiv">
                                <div class="cardHeader">
                                    <p class="cardTitle">MY CLIENTS</p>
                                </div>
                            </div>
                            <div class="cardContent">
                                <div class="cardContentProfile">
                                    <div v-if="clientsWeb.length > 0">
                                        <div
                                            class="row"
                                            id="myWebRmMgRow"
                                            v-for="clientWeb in clientsWeb"
                                            :key="clientWeb.id"
                                        >
                                            <div class="col s10 m10 l10">
                                                <div class="cardImgMainDiv">
                                                    <div class="cardImgDiv">
                                                        <i
                                                            class="material-icons"
                                                            id="cardImg"
                                                            >person</i
                                                        >
                                                    </div>
                                                    <p class="cardProName">
                                                        {{ clientWeb.name }}
                                                    </p>
                                                    <div class="col s2 m2 l2">
                                                        <a
                                                            href="#"
                                                            id="cardViewLink"
                                                            @click="
                                                                goToDomain(
                                                                    clientWeb
                                                                )
                                                            "
                                                            >View</a
                                                        >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col s12">
                                                <hr class="cardLine" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" v-else>
                                        <p
                                            class="white-text center-align noVertMargin p10"
                                        >
                                            You have not created any website yet
                                            for a client! Work Hard bro!
                                        </p>
                                    </div>
                                    <div class="row" id="myWebRmMgRow">
                                        <div class="col s12 center-align">
                                            <a
                                                @click="
                                                    navigateToClientsWebPages
                                                "
                                                class="waves-effect primary waves-light btn-small"
                                                ><i class="material-icons right"
                                                    >add</i
                                                >Create website</a
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col s12 m6 l6">
                            <div class="cardDiv">
                                <div class="cardHeader">
                                    <p class="cardTitle">MY MAIL</p>
                                </div>
                                <div class="cardContent">
                                    <div class="row" v-if="mail.length < 1">
                                        <p class="white-text center-align noVertMargin">No Mail.</p>
                                    </div>
                                    <div class="row" id="myMailDiv" v-else>
                                        <div class="col s10 m10 l10">
                                            <div class="cardImgMainDiv">
                                                <div class="cardImgDiv">
                                                    <i class="material-icons" id="cardImg">person</i>
                                                </div>
                                                <a href="#" class="cardProName">admin@whitecoatdomain.com</a>
                                            </div>
                                        </div>
                                    
                                        <div class="col s2 m2 l2">
                                            <p class="dashTimeAgo">2m</p>
                                        </div>
                                    
                                        <div class="col s10 offset-s2">
                                            <p class="mailCardTxt">
                                                Lorem Ipsum is simply dummy text
                                                of the printing and typesetting
                                                industry. Lorem Ipsum has been
                                                the industry's standard dummy
                                                text ever since the 1500s, when
                                                an unknown printer took a galley
                                                of type and scrambled it to make
                                                a type specimen book, Lorem
                                                Ipsum is simply dummy text of
                                                the printing and typesetting
                                                Lorem Ipsum has been the
                                                industry's standard dummy text
                                                ever since the 1500s,....
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col s12 m6 l6">
                            <div class="cardDiv">
                                <div class="cardHeader">
                                    <p class="cardTitle">Sales Emails</p>
                                </div>
                                <div class="cardContent white-text">
                                    <table class="highlight">
                                        <thead>
                                            <tr>
                                                <th>Subscribed</th>
                                                <th>Made first Change</th>
                                                <th>Emails Sent</th>
                                                <th>Emails Opened</th>
                                                <th>Rebouned</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>{{userSubscribedTrackerCount}}</td>
                                                <td>{{ userMadeChangesTrackerCount }}</td>
                                                <td>{{ emailSent }}</td>
                                                <td>{{ openedMails }}</td>
                                                <td>-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Template Stuff -->
                    <!--div class="row">
                        <a class="waves-effect waves-light btn" @click="pushCities()">Get Cities</a>
                    </div-->
                </div>
                <!-- <InnerFooterComponent /> -->
            </div>
        </div>
    </div>
</template>

<script>
    import MobileNavComponent from "../partials/MobileNavComponent.vue";
    import SidenavComponent from "../partials/SideNavComponent.vue";
    import InnerFooterComponent from "../partials/InnerFooterComponent.vue";
    export default {
        components: {
            SidenavComponent,
            MobileNavComponent,
            InnerFooterComponent,
        },
        data() {
            return {
                bg_img: "/media/img/istockphoto-1390124896-170667a.jpg",
                pro_img: "/media/img/yuna.jpg",
                clientsWeb: [],
                currentMonth: "",
                currentDay: "",
                currentDate: "",
                currentYear: "",
                currentTime: "",
                currentMidNoon: "",
                loading: false,
                months: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ],
                professions: [],
                template: {
                    profession_id: "",
                    title: "",
                    imageUrl: "",
                },
                templates: [],
                user: {},
                view: 0,
                mail: [],
                cities: null,
                userSubscribedTrackerCount: 0,
                userMadeChangesTrackerCount: 0,
                emailSent: 0,
                openedMails: 0,
            };
        },
        mounted() {
            this.getDate();
            this.getProfessions();
            this.getTemplates();
            this.getClientsWebsites();
            setInterval(this.getCurrentTimeInterval, 1000);
            this.getCities();
            this.fetchSubscribers();
            this.fetchUserMadeChanges();
            this.fetchUsersSentMailNOpened();
        },
        methods: {
            fetchSubscribers () {
                axios.get('/api/getSubscribers').then(res => {
                    this.userSubscribedTrackerCount = res.data.users.length;
                }).catch(err => {
                    console.log(err);
                })
            },
            fetchUserMadeChanges () {
                axios.get('/api/getusers_that_made_change').then(res => {
                    this.userMadeChangesTrackerCount = res.data.user.length;
                }).catch(err => {
                    console.log(err);
                })
            },
            fetchUsersSentMailNOpened () {
                axios.post(`${process.env.MIX_WCDSERVICE_URL}api/v1/track/tracker_records`).then(res => {
                    this.emailSent = res.data.emails.length;
                    this.openedMails = res.data.openedMails.length;
                }).catch(err => {
                    console.log(err);
                })
            },
            pushCities() {
                let postCity = async (city) => {
                    return axios
                        .post("https://whitecoatdomain.com/api/insertCity", city)
                        .then((res) => {
                            // console.log(city.id);
                            // this.cities.shift();
                            return true;
                        })
                        .catch((err) => {
                            console.log(err);
                            return false;
                        });
                };

                // this.cities.forEach(async function(city){
                //     await postCity(city);
                // });

                let i = 0;
                let citiesLen = this.cities.length;

                function myLoop(cities) {
                    setTimeout(async function () {
                        //  call a 3s setTimeout when the loop is called
                        console.log(cities[i]["id"]);

                        await postCity(cities[i]);
                        i++; //  increment the counter
                        if (i < citiesLen) {
                            //  if the counter < 10, call the loop function
                            myLoop(cities); //  ..  again which will trigger another
                        } //  ..  setTimeout()
                    }, 2500);
                    // console.log(cities[i]['id']);
                }

                myLoop(this.cities);
            },
            getCities() {
                axios
                    .get("/api/getCities/0")
                    .then((res) => {
                        // console.log(res.data.cities);
                        this.cities = res.data.cities;
                        alert("done");
                        alert("done");
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            createTemplate() {
                this.loading = !this.loading;
                let formData = new FormData();
                formData.append("imageUrl", this.template.imageUrl);
                formData.append("title", this.template.title);
                formData.append("profession_id", this.template.profession_id);
                axios
                    .post("/api/template", formData)
                    .then((res) => {
                        if (res.status == 201) {
                            this.loading = !this.loading;
                            M.toast({
                                html: res.data.message,
                                classes: "successNotifier",
                            });
                            this.templates.unshift(res.data.template);
                            this.template.title = "";
                            (this.template.imageUrl = ""),
                                (this.template.profession_id = "");
                            this.setView(0);
                        } else {
                            M.toast({
                                html: "File too large",
                                classes: "errorNotifier",
                            });
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            deleteTemplate(template) {
                this.loading = !this.loading;
                axios
                    .delete(`/api/template/${template.id}`)
                    .then((res) => {
                        if (res.status == 204) {
                            const findId = (rol) => rol.id === template.id;
                            this.templates.splice(
                                this.templates.findIndex(findId),
                                1
                            );
                            this.loading = !this.loading;
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            getDate() {
                const d = new Date();
                this.currentMonth = this.months[d.getMonth()].substring(0, 3);
                this.currentDay = d.getDate() + this.dayFormatter(d.getDate());
                this.currentDate = d.getDate();
                this.currentYear = d.getFullYear();
                this.currentMidNoon = d.getHours() >= 12 ? "pm" : "am";
                this.getCurrentTimeInterval();
            },
            gotoDomain(website) {
                let domain =
                    typeof website.domains === "object"
                        ? website.domains[0].domain
                        : website.domains;
                window.open(`https://${domain}.whitecoatdomain.com`, "_blank");
            },
            dayFormatter(d) {
                {
                    if (d > 3 && d < 21) return "th";
                    switch (d % 10) {
                        case 1:
                            return "st";
                        case 2:
                            return "nd";
                        case 3:
                            return "rd";
                        default:
                            return "th";
                    }
                }
            },
            formatAMPM(d) {
                var hours = d.getHours();
                var minutes = d.getMinutes();
                var ampm = hours >= 12 ? "pm" : "am";
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? "0" + minutes : minutes;
                var strTime = hours + ":" + minutes + " " + ampm;
                return strTime;
            },
            getCurrentTimeInterval() {
                const date = new Date();
                this.currentTime = `${date.getHours()}:${String(
                    date.getMinutes()
                ).padStart(2, "0")}`;
            },
            getProfessions() {
                axios
                    .get("/api/profession")
                    .then((res) => {
                        if (res.status == 200) {
                            this.professions = res.data.professionals;
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            getUser(e) {
                this.user = e;
            },
            getTemplates() {
                axios
                    .get("/api/template")
                    .then((res) => {
                        if (res.status == 200) {
                            this.templates = res.data.templates;
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            getClientsWebsites() {
                this.loading = true;
                axios
                    .get("/api/tenancies")
                    .then((res) => {
                        if (res.data.status == 200) {
                            this.clientsWeb = res.data.tenants.slice(0, 2);
                        }
                        this.loading = false;
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            navigateToClientsWebPages() {
                window.location.replace("/supre/client");
            },
            previewImage(event) {
                if (event.target.files.length !== 0) {
                    this.template.imageUrl = event.target.files[0];
                    this.template.imagePreview = URL.createObjectURL(
                        this.template.imageUrl
                    );
                }
            },

            setView(num) {
                this.view = num;
            },
        },
        props: ["_token"],
    };
</script>
<style>
    .centered {
        color: #000;
        text-align: center;
        padding-top: 20px;
    }
    .btn_file {
        background-color: #7746ff;
    }
    .btn_file:hover {
        background-color: #aa8ff5;
    }
    .center {
        margin: auto;
        width: 60%;
        border: 1px solid #b59ff0;
        padding: 30px;
        border-radius: 5px;
        background-color: #c1b8d8;
    }
</style>