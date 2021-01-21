<template>
    <div class="main">
        <h1 class="has-text-centered is-uppercase"><strong>Upload Files!!!</strong></h1>
        <div class="container">
            <form name="form-upload" ref="form">
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
                                        people.xml file
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
                                        shiporders.xml file
                                    </span>
                                </span>
                                <span class="file-name file-name-shiporders">
                                    {{ inputShiporder.fileName }}
                                </span>
                            </label>
                        </div>
                        <span class="message" :class="inputShiporder.isError ? '' : 'is-hidden is-danger'">{{ inputShiporder.errorText }}</span>
                    </div>
                </div>
            </form>
            
            <div class="has-text-centered">
                <button class="button is-primary is-medium btn-upload" @click="upload()">
                    Upload
                </button>
                <br><br>
                <div v-if="send.upload.hasErrors" class="notification is-danger is-light" :class="this.send.upload.hidden ? 'is-hidden' : ''">
                    <button class="delete" @click="closeNotification()"></button>
                    {{ send.upload.message }}
                </div>
                <div v-else class="notification is-primary is-light" :class="this.send.upload.hidden ? 'is-hidden' : ''">
                    <button class="delete" @click="closeNotification()"></button>
                    {{ send.upload.message }}
                </div>
            </div>

            <br> 

            <div class="xml-files has-text-centered">
                <div class="button-group">
                    <button class="button is-primary is-medium btn-upload" @click="getXml('people')">
                        People XML file
                    </button>

                    <button class="button is-primary is-medium btn-upload" @click="getXml('shiporders')">
                        Shiporders XML file
                    </button>
                </div>
                <span class="error-message" :class="send.xml.hasErrors ? '' : 'is-hidden'">{{ send.errorMessage }}</span>
            </div>

            <table class="table table-people is-hoverable is-fullwidth" :class="table.people.hidden ? 'is-hidden' : ''">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contacts</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="person in people" :key="person.id">
                        <th>{{ person.id }}</th>
                        <td>{{ person.name }}</td>
                        <td>
                            <span v-for="contact in person.contacts" :key="contact">
                                {{ contact }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-shiporders is-hoverable is-fullwidth" :class="table.shiporders.hidden ? 'is-hidden' : ''">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Person ID</th>
                        <th>Address</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in shiporders" :key="order.id">
                        <th>{{ order.id }}</th>
                        <td>{{ order.person_id }}</td>
                        <td>{{ order.address.location }}, {{ order.address.city }} - {{ order.address.country }}</td>
                        <td>
                            <span v-for="item in order.items" :key="item.title">
                                Title: {{ item.title }}<br>
                                Note: {{ item.note }}<br>
                                Quantity: {{ item.quantity }}<br>
                                Price: US$ {{ item.price }}<br><br>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
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
                upload: {
                    hasErrors: false,
                    message: '',
                    hidden: true
                },
                xml: {
                    hasErrors: false,
                    errorMessage: ''
                }
            },
            table: {
                people: {
                    hidden: true
                },
                shiporders: {
                    hidden: true
                }
            },
            people: [],
            shiporders: []
        }
    },
    methods: {
        async upload () {
            let peopleXmlLength = document.getElementsByClassName('people')[0].files.length
            let shipordersXmlLength = document.getElementsByClassName('shiporders')[0].files.length

            this.send.upload.hidden = false

            if (peopleXmlLength === 0 || shipordersXmlLength === 0) {
                this.send.upload.hasErrors = true
                this.send.upload.message = 'É preciso escolher o arquivo de envio'
            } else {

                const form = this.$refs.form

                if (this.send.hasErrors) {
                    this.send.errorMessage = 'Arquivo(s) de envio inválido(s)'
                } else {
                    let tokenEndpoint = this.baseUrl + '/api/token/get'
                    
                    await axios.get(tokenEndpoint)
                    .then(response => {

                        let uploadEndpoint = this.baseUrl + '/api/upload'
                        let formData = new FormData(form)
                        
                        axios.post(
                            uploadEndpoint, 
                            formData,
                            {
                                headers: { 'Content-Type': 'multipart/form-data', 'Authorization': `${response.data.token}` }
                            }
                        )
                        .then(response => {
                            this.send.upload.hasErrors = false
                            this.inputPeople.fileName = 'Nenhum arquivo selecionado'
                            this.inputShiporder.fileName = 'Nenhum arquivo selecionado'
                            this.send.upload.message = response.data.message
                        })
                        .catch(response => {
                            this.send.upload.hasErrors = true
                            this.send.upload.message = response.data.error.message  
                        })

                    })
                    .catch(response => {
                        this.send.upload.hasErrors = true
                        this.send.upload.message = response.data.error.message
                    })

                }
                
            }

        },
        async getXml (xml) {

            let endpoint = '/api/xml/get-content?file-name=' + xml
            let tokenEndpoint = this.baseUrl + '/api/token/get'

            await axios.get(tokenEndpoint)
            .then(response => {
                
                axios.get(
                    this.baseUrl + endpoint,
                    {
                        headers: { 'Authorization': `${response.data.token}` }
                    }
                )
                .then(response => {
                    
                    if (xml === 'people') {
                        this.table.people.hidden = false
                        this.table.shiporders.hidden = true
                        this.people = response.data
                    } else {
                        this.table.shiporders.hidden = false
                        this.table.people.hidden = true
                        this.shiporders = response.data
                    }
                    
                    this.inputPeople.fileName = 'Nenhum arquivo selecionado'
                    this.inputShiporder.fileName = 'Nenhum arquivo selecionado'
                })
                .catch(response => {
                    this.send.upload.hasErrors = true
                    this.send.upload.message = response.data.error.message
                })

            })
            .catch(response => {
                this.send.upload.hasErrors = true
                this.send.upload.message = response.data.message
            })            
        },
        checkFile (inputClass) {
            const input = document.getElementsByClassName(`${inputClass}`)
            this.send.upload.hidden = true
            if (input[0].files.length > 0) {
                if (inputClass.includes('people')) {
                    this.inputPeople.isChosen = true
                    if (input[0].files[0].name.includes('shiporders')) {
                        this.inputPeople.isError = true
                        this.inputPeople.fileName = 'Arquivo inválido'
                        this.inputPeople.errorText = `É preciso selecionar o arquivo 'people.xml'`
                        this.send.upload.hasErrors = true
                    } else {
                        this.inputPeople.isError = false
                        this.inputPeople.errorText = ''
                        this.send.upload.hasErrors = false
                        this.send.upload.message = ''
                        this.inputPeople.fileName = input[0].files[0].name
                    } 
                } else {
                    this.inputShiporder.isChosen = true
                    if (input[0].files[0].name.includes('people')) {
                        this.inputShiporder.isError = true
                        this.inputShiporder.fileName = 'Arquivo inválido'
                        this.inputShiporder.errorText = `É preciso selecionar o arquivo 'shiporders.xml'`
                        this.send.upload.hasErrors = true
                    } else {
                        this.inputShiporder.isError = false
                        this.inputShiporder.errorText = ''
                        this.send.upload.hasErrors = false
                        this.send.upload.message = ''
                        this.inputShiporder.fileName = input[0].files[0].name
                    }
                }
            }
        },
        closeNotification () {
            this.send.upload.hidden = true
            this.send.upload.message = ''
        }
    }
}
</script>

<style>

h1 {
    font-size: 30px;
}

.main {
    margin: 0 auto;
    padding: 0.6em;
    width: 90%;
}

.container {
    margin: 0 auto;
    width: 65%;
}

.input-group {
    padding: 30px 0;
}

.upload-success,
.fa-check-circle {
    color: green;
}

.button-group {
    display: flex;
    justify-content: space-around;
    width: 100%;
}

.xml-files {
    display: flex;
    flex-direction: column;
}

.fa-times-circle,
.error-message,
.upload-error {
    color: red;
}

.upload-people,
.upload-shiporders {
    padding: 15px 0;
}

</style>