<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
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

            }
        },
        methods: {

            permissions(){
                navigator.permissions.query({name:'geolocation'})
                    .then(function(permissionStatus) {
                        console.log('geolocation permission state is ', permissionStatus.state);

                        permissionStatus.onchange = function() {
                            console.log('geolocation permission state has changed to ', this.state);
                        };
                    });
            }
        },
        mounted() {
            console.log('Component mounted.')
            let options = {
                acceptAllDevices: true,
            }

            navigator.bluetooth.requestDevice(options).then(function(device) {
                console.log('Name: ' + device.name);
                // Do something with the device.
            })
                .catch(function(error) {
                    console.log("Something went wrong. " + error);
                });
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
                console.log('This configuration is ' +  (result.supported ? '' : 'not ') + 'supported.')
            });

            console.log(window.navigator);

            navigator.mediaDevices.enumerateDevices()
                .then(function(devices) {
                    devices.forEach(function(device) {
                        console.log(device.kind + ": " + device.label +
                            " id = " + device.deviceId);
                    });
                })
                .catch(function(err) {
                    console.log(err.name + ": " + err.message);
                });

            if ('credentials' in window.navigator) {
                window.navigator.credentials.get({password: true})
                    .then(function(creds) {
                        console.log(creds);
                    });
            } else {
                console.log('No credentials');
            };
            console.log(window.performance);
            console.log(window.clientInformation.geolocation.getCurrentPosition(function (position) { console.log(position) }));
        }
    }
</script>
