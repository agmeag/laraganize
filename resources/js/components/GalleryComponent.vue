<template>
    <v-app class="inner-content">
        <div class="gallery-content">
            <div class="gallery-directories">
                <template v-for="(directory, i) in folders">
                    <div
                        :key="'folder' + i"
                        class="directory"
                        v-on:click="setFolder(directory)"
                    >
                        <i class="bx bx-folder"></i>
                        <span style="margin: 0 4px">{{ directory.name }}</span>
                        <i class="bx bx-aperture"></i>
                    </div>
                </template>
            </div>
            <div class="image-carrette">
                <template v-for="(file, i) in gallery_files.files">
                    <img
                        class="gallery-img"
                        v-bind:key="'files' + i"
                        :src="'/' + file.dirname + '/' + file.basename"
                        alt=""
                        v-on:click="viewImage(file, i)"
                        v-if="imgLoaded"
                    />
                    <div
                        v-bind:key="'files_' + i"
                        v-if="!imgLoaded"
                        class="gallery-img"
                        style="
                            font-size: 2.5rem;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            color: #cacaca;
                            cursor: default;
                        "
                    >
                        <i
                            class="bx bxs-analyse bx-spin bx-burst"
                            style="cursor: wait"
                        ></i>
                    </div>
                </template>
            </div>
        </div>
        <v-dialog
            v-model="dialog"
            fullscreen
            hide-overlay
            style="background-color: #000000bf !important"
        >
            <v-card style="background-color: #000000bf !important">
                <v-toolbar v-toolbar dark color="black">
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title
                        ><template v-if="current_image.file">
                            {{ current_image.file.basename }}
                        </template>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark text @click="dialog = false"> Save </v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <div
                    class="d-flex"
                    style="background-color: transparent !important"
                >
                    <template v-if="current_image.file">
                        <img
                            loading="lazy"
                            v-bind:key="'image' + i"
                            class="single-image"
                            :src="
                                '/' +
                                current_image.file.dirname +
                                '/' +
                                current_image.file.basename
                            "
                            alt=""
                        />
                    </template>
                    <div class="gallery-directories-single">
                        <template v-for="(directory, i) in folders">
                            <div
                                :key="'folder' + i"
                                class="directory-single"
                                v-on:click="moveToFolder(directory)"
                            >
                                <i class="bx bx-folder"></i>
                                <span
                                    style="
                                        margin: 0px 4px;
                                        white-space: nowrap;
                                        text-overflow: ellipsis;
                                        overflow: hidden;
                                    "
                                    >{{ directory.name }}</span
                                >
                                <i class="bx bx-upload"></i>
                            </div>
                        </template>
                    </div>
                </div>
            </v-card>
        </v-dialog>
        <div class="gallery-buttons">
            <div class="gallery-button" v-on:click="previousImages()">
                <i class="bx bxs-left-arrow"></i>
            </div>
            <div class="gallery-button" v-on:click="nextImages()">
                <i class="bx bxs-right-arrow"></i>
            </div>
        </div>
    </v-app>
</template>
<style>
* {
    transition: all 0.3s;
}

.size-disappear {
    width: 0px;
    height: 0px;
}
.gallery-buttons {
    position: fixed;
    display: flex;
    bottom: 20px;
    right: 30px;
    font-size: 2.6rem;
    justify-content: center;
    align-items: center;
}

.gallery-button {
    background-color: #9191915c;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    padding: 10px;
    color: #ffffff6b;
    cursor: pointer;
    margin: 0 20px;
}

.gallery-button:hover {
    background-color: rgba(0, 0, 0, 0.76);
    color: #ffffff86;
}

.gallery-directories-single {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
}

.single-image {
    object-fit: contain;
    width: 100%;
    max-height: 600px;
    margin: 20px;
}

.gallery-img-cnt {
    width: 200px;
    height: 150px;
}

.image-carrette {
    width: calc(100% - 200px);
    display: flex;
    flex-wrap: wrap;
    overflow-y: scroll;
    overflow-x: hidden;
    height: 100%;
    padding: 20px 0;
}

.gallery-img {
    object-fit: cover;
    width: 215px;
    height: 130px;
    margin: 2px;
    cursor: pointer;
}

.gallery-img:hover {
    padding: 5px;
}

.gallery-content {
    display: flex;
    min-height: 100%;
    height: 100%;
}
.inner-content {
    background-color: #eef0f4 !important;
    width: 100%;
    height: 100%;
    min-height: 100%;
    min-width: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.gallery-directories {
    width: 200px;
    height: 100%;
    min-height: 100%;
    overflow-y: auto;
    background-color: #fff;
    font-size: 0.8rem;
    /* display: flex;
    justify-content: space-around;
    align-items: center;
    flex-direction: column; */
    overflow-x: hidden;
    font-weight: bolder;
    color: #606060;
    font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande",
        "Lucida Sans", Arial, sans-serif;
}

.gallery-directories--single {
    width: 100%;
    background-color: #fff;
    font-size: 0.8rem;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    font-weight: bolder;
    color: #606060;
    font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande",
        "Lucida Sans", Arial, sans-serif;
}

.directory {
    width: 100%;
    text-align: center;
    cursor: pointer;
    display: flex;
    justify-content: left;
    padding-left: 20px;
    align-items: center;
    margin: 15px 0;
}

.directory-single {
    text-align: center;
    cursor: pointer;
    margin: 7px 6px;
    background-color: #ddd;
    width: 192px;
    border-radius: 12px;
    padding: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.directory:hover {
    color: #81abeb;
}

@media (max-width: 768px) {
    .desktop {
        display: none;
    }

    .mobile {
        display: flex;
    }
}
</style>
<script>
export default {
    data() {
        return {
            variable: null,
            files: [],
            folders: [
                {
                    text: "Root",
                    url: "gallery",
                    name: "Gallery",
                },
                {
                    text: "University",
                    url: "/UNIVERSITY",
                    name: "UNIVERSITY",
                },
                {
                    text: "Michelle",
                    url: "/MICHELLE",
                    name: "MICHELLE",
                },
                {
                    text: "Medical",
                    url: "/MEDICAL",
                    name: "MEDICAL",
                },
                {
                    text: "Family",
                    url: "/FAMILY",
                    name: "FAMILY",
                },
                {
                    text: "Friends",
                    url: "/FRIENDS",
                    name: "FRIENDS",
                },
                {
                    text: "Ideas",
                    url: "/IDEAS",
                    name: "IDEAS",
                },
                {
                    text: "UI",
                    url: "/UI",
                    name: "UI",
                },
                {
                    text: "Me",
                    url: "/ME",
                    name: "ME",
                },
                {
                    text: "Memes",
                    url: "/MEMES",
                    name: "MEME",
                },
                {
                    text: "PC Help Tools",
                    url: "/PC_HELP_TOOLS",
                    name: "PC",
                },
                {
                    text: "Work",
                    url: "/WORK",
                    name: "WORK",
                },
                {
                    text: "Games",
                    url: "/GAMES",
                    name: "GAMES",
                },
                {
                    text: "Famdocs",
                    url: "/FAMDOCS",
                    name: "FAMDOC",
                },

                {
                    text: "Grad",
                    url: "/GRAD_2021",
                    name: "GRAD_2021",
                },
                {
                    text: "Birthday 2021",
                    url: "/BIRTHDAY_2021",
                    name: "BIRTHDAY_2021",
                },
                {
                    text: "Birthday Mano",
                    url: "/BIRTHDAY_CARLOS_2021",
                    name: "BIRTHDAY_CARLOS_2021",
                },
                {
                    text: "Fotos Astrid Mano",
                    url: "/ASTRID_CARLOS",
                    name: "ASTRID_CARLOS",
                },
                {
                    text: "TE BODA",
                    url: "/TE_BODA_AVILES_ALVARADO",
                    name: "TE_BODA_AVILES_ALVARADO",
                },
                {
                    text: "Boda Aviles Alvarado",
                    url: "/BODA_AVILES_ALVARADO_2022",
                    name: "BODA_AVILES_ALVARADO_2022",
                },
                {
                    text: "MISC",
                    url: "/MISC",
                    name: "MISC",
                },
            ],
            current_folder: "gallery",
            current_image: {
                file: null,
                index: null,
            },
            gallery_files: {
                files: [],
                page: 0,
            },
            dialog: false,
            imgLoaded: false,
            imgperPage: 30,
        };
    },

    mounted() {
        window.addEventListener("keyup", (ev) => {
            this.detectKey(ev); // declared in your component methods
        });
        this.winScreen();
        this.getFiles();
    },

    watch: {
        customName: function (newvalue, oldvalue) {
            if (newvalue == true) {
                this.folderName = false;
            }
        },
        folderName: function (newvalue, oldvalue) {
            if (newvalue == true) {
                this.customName = false;
            }
        },
    },

    beforeMount() {},

    created() {},

    destroyed() {},
    methods: {
        winScreen() {
            var h = window.innerHeight;
            var w = window.innerWidth;
            console.log(h + "-" + w);
            if (w >= 1000 || h >= 800) {
                this.imgperPage = 30;
            }

            if (w < 1000 && h < 800) {
                this.imgperPage = 15;
            }

            if (w <= 500 || h <= 500) {
                this.imgperPage = 10;
            }
        },

        imagesLoaded() {
            const images = this.gallery_files.files.map((imageSrc) => {
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.src = "/" + imageSrc.dirname + "/" + imageSrc.basename;
                    img.onload = resolve;
                    img.onerror = reject;
                });
            });

            Promise.all(images)
                .then(() => {
                    console.log("Images loaded!");
                    this.imgLoaded = true;
                })
                .catch((error) => {
                    console.error("Some image(s) failed loading!");
                    console.error(error.message);
                });
        },

        viewImage(file, i) {
            this.current_image.file = file;
            this.current_image.index = i;
            this.dialog = true;
        },

        setFolder(directory) {
            this.current_folder = directory.url;
            this.getFiles();
        },

        detectKey(ev) {
            let keycode = ev.keyCode;
            switch (keycode) {
                // Key Space
                case 32:
                    break;
                // Left
                case 37:
                    this.previousImages();
                    break;
                // Right
                case 39:
                    this.nextImages();
                    break;
            }
        },

        previousImages() {
            let page = this.gallery_files.page;
            if (page <= 0) {
                page = 0;
            } else {
                page -= 1;
            }
            this.gallery_files.page = page;
            this.setGallery();
        },

        nextImages() {
            let page = this.gallery_files.page;
            let calc =
                this.files.length > 0 ? Math.ceil(this.files.length / 30) : 0;
            if (page < calc - 1) {
                page += 1;
            } else {
                page = calc - 1;
            }
            this.gallery_files.page = page;
            this.setGallery();
        },

        getFiles() {
            this.loading = true;
            axios
                .get("/gallery_/get_files", {
                    params: {
                        folders: JSON.stringify(this.folders),
                        current_folder: this.current_folder,
                    },
                })
                .then((response) => {
                    let files = response.data;
                    this.files = files.map((item) => {
                        let obj = {
                            basename: item.basename,
                            dirname: item.dirname,
                            extension: item.extension,
                            filename: item.filename,
                            loaded: false,
                        };
                        return obj;
                    });
                    this.loading = false;
                    this.setGallery();
                })
                .catch((error) => {
                    this.loading = false;
                    window.console.log(error);
                    if (error.response) {
                        window.console.log(error.response);
                        if (error.response.status == 401) {
                            location.reload();
                        }
                    }
                });
        },

        setGallery() {
            this.imgLoaded = false;
            this.gallery_files.files = [];
            for (
                var i = this.imgperPage * this.gallery_files.page;
                i < this.imgperPage * this.gallery_files.page + this.imgperPage;
                i++
            ) {
                if (this.files[i]) {
                    this.gallery_files.files.push(this.files[i]);
                }
            }
            this.imagesLoaded();
        },

        deleteFile() {
            this.loading = true;
            let formData = new FormData();
            axios
                .post("/photo-gallery/delete_file", formData)
                .then((response) => {
                    this.loading = false;
                })
                .catch((error) => {
                    this.loading = false;
                    window.console.log(error);
                    if (error.response) {
                        window.console.log(error.response);
                        if (error.response.status == 401) {
                            location.reload();
                        }
                    }
                });
        },

        moveToFolder() {
            this.loading = true;
            axios
                .post("/photo-gallery/move-file", formData)
                .then((response) => {
                    this.loading = false;
                })
                .catch((error) => {
                    this.loading = false;
                    window.console.log(error);
                    if (error.response) {
                        window.console.log(error.response);
                        if (error.response.status == 401) {
                            location.reload();
                        }
                    }
                });
        },
    },
};
</script>
