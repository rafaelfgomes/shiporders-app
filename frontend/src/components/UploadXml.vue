<template>
    <div class="main">
        <h1 class="has-text-centered">Upload Files!!!</h1>
        <div class="container" >
            <div class="input-group">
                <div class="input-container">
                    <div class="file has-name is-fullwidth upload-people">
                        <label class="file-label is-flex is-justify-content-center is-align-items-center">
                            <input class="file-input people" type="file" name="people" ref="people" accept="text/xml" @change="checkFile('people')" required>
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label">
                                    Arquivo people.xml
                                </span>
                            </span>
                            <span class="file-name file-name-people">
                                {{ inputPeople.fileName }}
                            </span>
                        </label>    
                    </div>
                    <span class="error-message" :class="inputPeople.isError ? '' : 'is-hidden'">{{ inputPeople.errorText }}</span>
                </div>
                
                <div class="input-container">
                    <div class="file has-name is-fullwidth upload-shiporders">
                        <label class="file-label">
                            <input class="file-input shiporders" type="file" name="shiporders" ref="shiporders" accept="text/xml" @change="checkFile('shiporders')" required>
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label">
                                    Arquivo shiporders.xml
                                </span>
                            </span>
                            <span class="file-name file-name-shiporders">
                                {{ inputShiporder.fileName }}
                            </span>
                        </label>
                    </div>
                    <span class="error-message" :class="inputShiporder.isError ? '' : 'is-hidden'">{{ inputShiporder.errorText }}</span>
                </div>
                
                <!-- <input type="file" name="upload-people" id="people" ref="people" accept="text/xml"><br /> -->
                <!-- <input type="file" name="upload-shiporders" id="shiporders" ref="shiporders" accept="text/xml"> -->
            </div>
            <div class="submit has-text-centered">
                <button class="button is-primary is-medium btn-upload" @click="upload()">
                    Enviar
                </button><br />
                <span class="error-message" :class="send.hasErrors ? '' : 'is-hidden'">{{ send.errorMessage }}</span>
            </div>
            <div class="box" :class="infoArea.hidden ? 'is-hidden' : ''">
                {{ infoArea.text }}
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios'

export default {
    name: 'Upload',
    data () {
        return {
            baseUrl: 'http://0.0.0.0:8686',
            inputPeople: {
                fileName: 'Nenhum arquivo selecionado',
                isChosen: false,
                isError: false,
                errorText: '',
                isDanger: false
            },
            inputShiporder: {
                fileName: 'Nenhum arquivo selecionado',
                isChosen: false,
                isError: false,
                errorText: '',
                isDanger: false
            },
            send: {
                hasErrors: false,
                errorMessage: ''
            },
            infoArea: {
                text: '',
                hidden: true
            }
        }
    },
    methods: {
        async upload () {

            if (this.send.hasErrors) {
                this.send.errorMessage = 'Arquivo(s) de envio inválido(s)'
            } else {

                let endpoint = '/upload'
                let formData = new FormData();
                formData.append('people', this.$refs.people)
                formData.append('shiporders', this.$refs.shiporders)

                await axios.post(
                    this.baseUrl + endpoint, 
                    formData
                )
                .then((response) => {
                    this.infoArea.hidden = false
                    this.infoArea.text = response.data
                    this.inputPeople.fileName = ''
                    this.inputShiporder.fileName = ''
                })
                .catch(() => (
                    this.info = "Houve um problema"
                ))

            }

        },
        checkFile (inputClass) {
            const input = document.getElementsByClassName(`${inputClass}`)
            if (input[0].files.length > 0) {
                if (inputClass.includes('people')) {
                    this.inputPeople.isChosen = true
                    if (input[0].files[0].name.includes('shiporders')) {
                        this.inputPeople.isError = true
                        this.inputPeople.fileName = 'Arquivo inválido'
                        this.inputPeople.errorText = `É preciso selecionar o arquivo 'people.xml'`
                        this.send.hasErrors = true
                    } else {
                        this.inputPeople.isError = false
                        this.inputPeople.errorText = ''
                        this.send.hasErrors = false
                        this.send.errorMessage = ''
                        this.inputPeople.fileName = input[0].files[0].name
                    }
                } else {
                    this.inputShiporder.isChosen = true
                    if (input[0].files[0].name.includes('people')) {
                        this.inputShiporder.isError = true
                        this.inputShiporder.fileName = 'Arquivo inválido'
                        this.inputShiporder.errorText = `É preciso selecionar o arquivo 'shiporders.xml'`
                        this.send.hasErrors = true
                    } else {
                        this.inputShiporder.isError = false
                        this.inputShiporder.errorText = ''
                        this.send.hasErrors = false
                        this.send.errorMessage = ''
                        this.inputShiporder.fileName = input[0].files[0].name
                    }
                }
            }
        }
    }
}
</script>

<style>

.main {
    margin: 0 auto;
    padding: 0.6em;
    width: 90%;
}

.container {
    margin: 0 auto;
    width: 70%;
}

.input-group {
    padding: 30px 0;
}

.fa-check-circle {
    color: green;
}

.fa-times-circle,
.error-message {
    color: red;
}

.upload-people,
.upload-shiporders {
    padding: 15px 0;
}

.box {
    margin-top: 50px;
    height: 400px;
}

</style>