<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                        <!--<p v-model="permissionState"></p>-->
                        <p v-model="mediaSupported"></p>
                        <p v-model="navigator"></p>
                        <div v-for="device in devices">
                            <p v-model="device"></p>
                        </div>
                        <p v-model="credentials"></p>
                        <p v-model="performance"></p>
                        <p v-model="position"></p>
                    </div>
                    <input  id="Button1"  type="button"  value="Button"
                            name="Button1"  language=javascript  @click="permissions()">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                permissionState: '',
                mediaSupported: '',
                navigator: '',
                devices: [],
                credentials: '',
                performance: '',
                position: ''
            }
        },
        methods: {

            permissions(){
                let options = {
                    acceptAllDevices: true,
                }

                /*navigator.bluetooth.requestDevice(options).then(function(device) {
                    console.log('Name: ' + device.name);

                })
                    .catch(function(error) {
                        console.log("Something went wrong. " + error);
                    });*/
                //console.log(window.navigator.clipboard.readAsText());

                //Create media configuration to be tested
                const mediaConfig = {
                    type : 'file', // or 'media-source'
                    video : {
                        contentType : "video/webm;codecs=vp8", // valid content type
                        width : 800,     // width of the video
                        height : 600,    // height of the video
                        bitrate : 10000, // number of bits used to encode 1s of video
                        framerate : 30   // number of frames making up that 1s.
                    }
                };

                // check support and performance
                navigator.mediaCapabilities.decodingInfo(mediaConfig).then(function(result){
                    this.media.supported = 'This configuration is ' +  (result.supported ? '' : 'not ') + 'supported.'
                });

                this.navigator = window.navigator;

                navigator.mediaDevices.enumerateDevices()
                    .then(function(devices) {
                        let i=0;
                        devices.forEach(function(device) {
                            this.devices[i] = device.kind + ": " + device.label +
                                " id = " + device.deviceId;
                            i++;
                        });
                    })
                    .catch(function(err) {
                        this.devices[0] = err.name + ": " + err.message;
                    });

                if ('credentials' in window.navigator) {
                    window.navigator.credentials.get({password: true})
                        .then(function(creds) {
                            this.credentials = creds;
                        });
                } else {
                    this.credentials = 'No credentials';
                };
                this.performance = window.performance;
                document.write(window.clientInformation.geolocation.getCurrentPosition(function (position) {
                    this.position = position;
                }));

                navigator.permissions.query({name:'geolocation'})
                    .then(function(permissionStatus) {
                        this.permission.state = 'geolocation permission state is ' + permissionStatus.state;

                        permissionStatus.onchange = function() {
                            this.permission.state = 'geolocation permission state has changed to ' + this.state;
                        };
                    });
            }
        },
        mounted() {
            console.log('Component mounted.')

        }
    }
</script>
