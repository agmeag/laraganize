<template>
    <div class="inner-content">
        <div class="btn-div">
            <div v-on:click="toogleImagesGrid()" class="btn-cnt">
                <i class="bx bxs-grid-alt"></i>
            </div>
            <div v-on:click="deleteFile(image, index)" class="btn-cnt">
                <i class="bx bxs-trash"></i>
            </div>
            <div
                v-on:click="deployFolders = !deployFolders"
                id="selection-folder-btn"
                class="mobile btn-cnt"
            >
                <i class="bx bx-menu"></i>
            </div>
        </div>
        <div class="w-100 mobile">
            <div class="folders mobile w-100" v-if="deployFolders">
                <template v-for="(folder, i) in folders">
                    <div
                        class="btn-folder"
                        v-bind:key="'folder' + i"
                        v-on:click="
                            selectFolder(folder.url, folder.name, image, index)
                        "
                    >
                        {{ folder.text }}
                    </div>
                </template>
            </div>
        </div>
        <div class="w-100 mobile folder-selected-cnt">
            <div class="mobile folder-selected">
                Folder: {{ folderSelected.name }}
            </div>
        </div>

        <div class="img-section">
            <div style="width: 100%">
                <v-row class="d-flex justify-center align-center ma-0 pa-0">
                    <v-col
                        class="d-flex justify-center align-center ma-0 pa-0"
                        cols="12"
                        md="5"
                        sm="12"
                        xs="12"
                    >
                        <v-text-field
                            hide-details="auto"
                            dense
                            label="Image"
                            placeholder="Image"
                            outlined
                            v-model="image"
                            readonly
                            class="ma-0 pa-0"
                            dark
                        ></v-text-field>
                    </v-col>
                    <v-col
                        class="d-flex justify-center align-center ma-0 pa-0"
                        v-if="customName"
                        cols="12"
                        md="5"
                        sm="12"
                        xs="12"
                    >
                        <v-text-field
                            hide-details="auto"
                            dense
                            label="New Name Image"
                            placeholder="New Name Image"
                            outlined
                            v-model="newName"
                            clearable
                            class="ma-0 pa-0"
                            dark
                        >
                        </v-text-field>
                    </v-col>
                </v-row>
                <div class="img-cnt">
                    <img :src="image" alt="" class="single-img" />
                </div>
            </div>
            <div class="desktop">
                <div>
                    <v-checkbox
                        v-model="customName"
                        inset
                        label="Custom Name"
                        dark
                        dense
                        class="ma-0 pa-0"
                        style="
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        "
                    ></v-checkbox>
                    <v-checkbox
                        v-model="folderName"
                        inset
                        label="Folder Name"
                        dark
                        dense
                        class="ma-0 pa-0"
                        style="
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        "
                    ></v-checkbox>
                </div>
                <div class="folders desktop">
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
                            class="btn-folder"
                            v-bind:key="'folder' + i"
                        >
                            {{ folder.text }}
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div class="imgs-footer-section">
            <template v-for="(item, i) in current_files">
                <div class="multiple-img-cnt" v-bind:key="'file' + i">
                    <img
                        :src="item.file"
                        alt=""
                        class="multiple-img"
                        v-on:click="selectImage(item.index, i)"
                    />
                    <div
                        v-on:click="deleteFile(item.file, item.index, i)"
                        class="multiple-delete"
                        v-if="multiple"
                    >
                        <i class="bx bxs-trash"></i>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<style>
* {
    transition: all 0.3s;
}
.inner-content {
    background-color: rgba(0, 0, 0, 0.85);
    width: 100%;
    height: 100%;
    min-height: 100%;
    min-width: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.btn-cnt {
    display: flex;
    flex-grow: 1;
    text-align: center;
    cursor: pointer;
    padding-top: 20px;
    padding-bottom: 20px;
    justify-content: center;
    align-items: center;
    /* padding: 10px; */
}

.btn-cnt:hover {
    background-color: #fff;
    color: #263238;
}
.btn-div {
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 1.5rem;
}

.folders {
    width: 260px;
    height: 100%;
    min-height: 100%;
    overflow-y: auto;
    background-color: #0000009e;
}

.btn-folder {
    font-size: 1.05rem;
    color: #625a5a;
    font-weight: bolder;
    text-transform: uppercase;
    border-top: 3px solid #00000073;
    cursor: pointer;
    text-align: center;
}

.btn-folder:hover {
    /* background-color: white; */
    color: white;
}

.img-section {
    display: flex;
    height: 100%;
    min-height: 100%;
}

* {
    transition: all 0.3s;
}

.img-cnt {
    width: 100%;
    text-align: center;
    height: 100%;
    min-height: 100%;
}

.single-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.imgs-footer-section {
    width: 100%;
    height: 145px;
    display: flex;
    overflow-y: hidden;
    overflow-x: auto;
    justify-content: center;
    align-items: center;
    min-height: 116px;
    background-color: #0000009e;
    position: fixed;
    z-index: 100;
    bottom: 0;
}

.multiple-img {
    width: 100%;
    object-fit: cover;
    height: 100%;
}

.multiple-img-cnt {
    height: 100px;
    width: 150px;
}

.multiple-img:hover {
    cursor: pointer;
}
#selection-folder-btn {
    display: none;
}

.mobile {
    display: none;
}

.folder-selected {
    text-align: center;
    color: rgb(56, 56, 56);
    background-color: white;
    border-radius: 12px;
    width: 80%;
    text-align: center;
    font-weight: bolder;
    font-size: 1.2rem;
    justify-content: center;
    align-items: center;
    text-transform: capitalize;
}

.folder-selected-cnt {
    justify-content: center;
    align-items: center;
}

@media (max-width: 768px) {
    .desktop {
        display: none;
    }

    .img-cnt {
        height: auto;
    }

    .img-section {
        display: flex;
        height: calc(100% - 370px);
        min-height: calc(100% - 370px);
    }

    #selection-folder-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-grow: 1;
    }

    .mobile {
        display: flex;
    }

    .folders {
        flex-direction: column;
        width: 100%;
        height: calc(100%-200px);
    }

    .btn-folder {
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: center;
    }

    .folder-selected {
        display: flex;
    }

    .folder-selected-cnt {
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
            index: 0,
            index2: 0,
            image: null,
            current_files: [],
            multiple: false,
            baseUrl: "/gallery/",
            newName: null,
            customName: false,
            folderName: false,
            deployFolders: false,
            folderSelected: {
                url: null,
                name: null,
                image: null,
                index: null,
            },
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
        selectFolder(url, name, image, index) {
            this.folderSelected.url = url;
            this.folderSelected.name = name;
            this.folderSelected.image = image;
            this.folderSelected.index = index;
            this.deployFolders = false;
        },
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
            // if (this.multiple) {
            this.current_files = [];
            for (var i = this.index; i < this.index + 5; i++) {
                if (this.files[i]) {
                    let obj = {
                        index: i,
                        file: this.baseUrl + this.files[i].basename,
                    };
                    this.current_files.push(obj);
                }
            }
            // } else {
            this.image = this.files[this.index]
                ? this.baseUrl + this.files[this.index].basename
                : null;
            // }
        },

        buildCurrent() {
            this.current_files = [];
            for (var i = this.index; i < this.index + 5; i++) {
                if (this.files[i]) {
                    let obj = {
                        index: i,
                        file: this.baseUrl + this.files[i].basename,
                    };
                    this.current_files.push(obj);
                }
            }
        },

        selectImage(index, i2 = null) {
            this.image = this.files[index]
                ? this.baseUrl + this.files[index].basename
                : null;
            this.index = index;
            this.index2 = i2;
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
                        let ind2 = this.current_files.findIndex(
                            (element) => element.index === this.index
                        );
                        this.current_files.splice(ind2, 1);
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
