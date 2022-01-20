<template>
    <div class="inner-content">
        <div class="desktop">
            <template v-if="!multiple">
                <div class="buttons">
                    <div
                        v-on:click="toogleImagesGrid()"
                        class="change-btn btn-ct icon flex-center"
                    >
                        <i class="bx bxs-grid-alt"></i>
                    </div>
                    <div
                        v-on:click="deleteFile(image, index)"
                        class="delete-btn btn-ct icon flex-center"
                    >
                        <i class="bx bxs-trash"></i>
                    </div>
                </div>
                <div class="buttons">
                    <template v-for="(folder, i) in folders">
                        <div
                            v-on:click="
                                moveToFolder(
                                    folder.url,
                                    folder.name,
                                    image,
                                    index
                                )
                            "
                            class="change-btn btn-ct"
                            v-bind:key="'folder' + i"
                        >
                            {{ folder.text }}
                        </div>
                    </template>
                </div>
                <div class="buttons">
                    <template>
                        <v-checkbox
                            v-model="customName"
                            inset
                            label="Custom Name"
                            dark
                            dense
                        ></v-checkbox>
                        <v-checkbox
                            v-model="folderName"
                            inset
                            label="Folder Name"
                            dark
                            dense
                        ></v-checkbox>
                    </template>
                </div>
                <!-- </div> -->
                <div class="w-100 flex ma-0-pa-0">
                    <v-row class="w-100 flex ma-0-pa-0">
                        <v-col cols="6" class="ma-0-pa-0">
                            <v-text-field
                                hide-details="true"
                                dense
                                label="Image"
                                placeholder="Image"
                                outlined
                                v-model="image"
                                readonly
                                class="ma-0-pa-0"
                                dark
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" class="ma-0-pa-0">
                            <v-text-field
                                hide-details="true"
                                dense
                                label="New Name Image"
                                placeholder="New Name Image"
                                outlined
                                v-model="newName"
                                clearable
                                class="ma-0-pa-0"
                                dark
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                </div>
                <div class="flex-w-ct">
                    <div
                        v-on:click="previousImage()"
                        class="left-btn btn-ct bordered flex b-font"
                    >
                        <i class="bx bxs-left-arrow"></i>
                    </div>
                    <div class="single-img-cnt">
                        <img :src="image" alt="" class="single-img" />
                    </div>
                    <div
                        v-on:click="nextImage()"
                        class="right-btn btn-ct bordered flex b-font"
                    >
                        <i class="bx bxs-right-arrow"></i>
                    </div>
                </div>
            </template>
            <template v-if="multiple">
                <div class="buttons">
                    <div
                        v-on:click="previousImage()"
                        class="change-btn btn-ct icon flex-center"
                    >
                        <i class="bx bxs-left-arrow"></i>
                    </div>
                    <div
                        v-on:click="toogleImagesGrid()"
                        class="change-btn btn-ct icon flex-center"
                    >
                        <i class="bx bxs-carousel"></i>
                    </div>
                    <div
                        v-on:click="nextImage()"
                        class="change-btn btn-ct icon flex-center"
                    >
                        <i class="bx bxs-right-arrow"></i>
                    </div>
                </div>
                <div
                    style="
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: center;
                        align-items: center;
                    "
                >
                    <template v-for="(item, i) in current_files">
                        <div class="multiple-img-cnt" v-bind:key="'file' + i">
                            <img :src="item.file" alt="" class="multiple-img" />
                            <div
                                v-on:click="
                                    deleteFile(item.file, item.index, i)
                                "
                                class="multiple-delete"
                            >
                                <i class="bx bxs-trash"></i>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <div></div>
    </div>
</template>
<style>
.inner-content {
    background-color: #263238;
    width: 100%;
    height: 100%;
    min-height: 100%;
    min-width: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
}
</style>
<script>
export default {
    data() {
        return {
            variable: null,
            files: [],
            index: 0,
            image: null,
            current_files: [],
            multiple: false,
            baseUrl: "/gallery/",
            newName: null,
            customName: false,
            folderName: false,
            folders: [
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
        };
    },

    mounted() {
        window.addEventListener("keyup", (ev) => {
            this.detectKey(ev); // declared in your component methods
        });
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

    beforeMount() {
        this.getFiles();
    },

    created() {},

    destroyed() {},
    methods: {
        detectKey(ev) {
            let keycode = ev.keyCode;
            // this.emptyDialog = true;
            //Key Space
            switch (keycode) {
                // Key Space
                case 32:
                    // this.toogleImagesGrid();
                    break;
                // Left
                case 37:
                    this.previousImage();
                    break;
                // Right
                case 39:
                    this.nextImage();
                    break;
            }
        },

        changeImages() {
            if (this.multiple) {
                this.current_files = [];
                for (var i = this.index; i < this.index + 20; i++) {
                    if (this.files[i]) {
                        let obj = {
                            index: i,
                            file: this.baseUrl + this.files[i].basename,
                        };
                        this.current_files.push(obj);
                    }
                }
            } else {
                this.image = this.files[this.index]
                    ? this.baseUrl + this.files[this.index].basename
                    : null;
            }
        },

        toogleImagesGrid() {
            this.multiple = !this.multiple;
            this.changeImages();
        },

        previousImage() {
            if (this.index > 0) {
                this.index -= 1;
            }
            this.changeImages();
            this.newName = null;
        },
        nextImage() {
            this.index += 1;
            if (this.files.length == this.index) {
                this.index = this.files.length - 1;
            }
            this.changeImages();
            this.newName = null;
        },
        getFiles() {
            this.loading = true;
            axios
                .get("/photo-gallery/get_files", {
                    params: { folders: JSON.stringify(this.folders) },
                })
                .then((response) => {
                    this.files = response.data;
                    this.loading = false;
                    this.changeImages();
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

        deleteFile(image, i, i2 = null) {
            this.loading = true;
            let formData = new FormData();
            formData.append("image", image);
            axios
                .post("/photo-gallery/delete_file", formData)
                .then((response) => {
                    if (this.multiple) {
                        this.files.splice(i, 1);
                        this.current_files.splice(i2, 1);
                    } else {
                        this.files.splice(i, 1);
                        // this.index += 1;
                        if (this.files.length == this.index) {
                            this.index = this.files.length - 1;
                        }
                        this.newName = null;
                        this.image = this.files[this.index]
                            ? this.baseUrl + this.files[this.index].basename
                            : null;
                    }
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

        moveToFolder(folder, fileName, image, i, i2 = null) {
            this.loading = true;
            if (this.newName == null || this.newName == "") {
                this.newName = this.image;
            }
            let formData = new FormData();
            formData.append("fileName", this.image);
            formData.append("newPath", folder);
            formData.append("newFileName", this.newName);
            // formData.append("customName", this.customName);
            formData.append("customNameCheck", this.customName ? 1 : 2);
            formData.append("folderName", fileName);
            formData.append("folderNameCheck", this.folderName ? 1 : 2);
            axios
                .post("/photo-gallery/move-file", formData)
                .then((response) => {
                    if (this.multiple) {
                        this.files.splice(i, 1);
                        this.current_files.splice(i2, 1);
                    } else {
                        this.files.splice(i, 1);
                        // this.index += 1;
                        if (this.files.length == this.index) {
                            this.index = this.files.length - 1;
                        }
                        this.newName = null;
                        this.image = this.files[this.index]
                            ? this.baseUrl + this.files[this.index].basename
                            : null;
                    }
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
