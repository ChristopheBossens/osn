<x-app-layout>
    <x-slot name="header">
        <h5 class="h5 font-weight-bold">
            <a href="{{ route('dashboard') }}">Campaign dashboard</a> / <a href="{{route('campaigns.show', $campaign->id)}}">{{ $campaign->title }}</a> / Create new message
        </h5>
    </x-slot>

    <div class="container pb-5" style="background-color: white">
        <div class="row">
            <div class="col-12 pt-3">
                <form action="{{ route('campaigns.messages.store', $campaign->id) }}" method="POST" id="campaignMessageForm">
                    @csrf
                    <div class="form-group">
                        <label for="urlInput">Enter the url of the link you want to share</label>
                        <input type="url" name="url" id="urlInput" class="form-control" required>
                        <div class="invalid-feedback">
                            This is not a proper URL
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="generatePreviewButton" onclick="generatePreviewButtonClicked(this)">
                            <div id="previewButtonLoading" class="d-none">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span>Loading...</span>
                            </div>
                            <div id="previewButtonReady">
                                <span>Generate previews</span>
                            </div>
                        </button>
                    </div>
                </form>
                <hr>
            </div>
        </div>
        <div class="row justify-content-between pb-3">
            <div class="col-5">
                <h4 class="text-center">Facebook preview</h4>
                <div id="invalidFacebookParameters" class="d-none"></div>
                <div class="card d-none" style="border-bottom: #dadde1;" id="facebookPreviewCard">
                    <img id="og_image" class="card-img-top" src="" alt="Facebook preview image">
                    <div class="card-body" style="border-bottom: 1px solid #dadde1; border-left: 1px solid #dadde1; border-right: 1px solid #dadde1; background-color: #F2F3F5">
                        <div id="og_site_name" style="font-family: Helvetica, Arial, sans-serif; color: #606770; font-size: 12px"></div>
                        <div id="og_title" style="font-family: Helvetica, Arial, sans-serif; font-weight: 600; font-size: 16px; color: #1D2129"></div>
                        <div id="og_description" style="font-family: Helvetica, Arial, sans-serif; color: #606770; font-size: 14px"></div>
                    </div>
                </div>
            </div>

            <div class="col-5">
                <h4 class="text-center">Twitter preview</h4>
                <div id="invalidTwitterParameters" class="d-none"></div>
                <div class="card d-none" id="twitterPreviewCard">
                    <img id="twitter_image" class="card-img-top" src="" alt="Facebook preview image" style="border-top-right-radius: .85714em; border-top-left-radius: .85714em;">
                    <div class="card-body pb-2" style="background-color: #ffffff; border-bottom-left-radius: .85714em; border-bottom-right-radius: .85714em; border: 1px solid #E1E8ED">
                        <h2 id="twitter_title" style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; font-weight: 700; font-size: 1em; color: #000000'></h2>
                        <div id="twitter_description" style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; color: #000000; font-size: 14px; max-height: 2.6em;'></div>
                        <div class="pt-2" id="twitter_site" style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; color: #8899a6; font-size: 12px'></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-3 ">
            <div class="col-12">
                <hr>
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-success" disabled id="createMessageButton" onclick="document.getElementById('campaignMessageForm').submit()">Create new message</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let urlInput = document.getElementById('urlInput');
            let generatePreviewButton = document.getElementById('generatePreviewButton');
            let previewButtonLoading = document.getElementById('previewButtonLoading');
            let previewButtonReady  = document.getElementById('previewButtonReady');
            let createMessageButton = document.getElementById('createMessageButton');

            const SCRAPEROUTE = '{{ route('scrape', 'url=:url') }}';

            /**
             * Preview Button callback
             * Validates the URL and proceeds with fetching meta data when valid
             */
            function generatePreviewButtonClicked(){
                urlInput.classList.remove('is-invalid');
                if(! urlInput.checkValidity()){
                    urlInput.classList.add('is-invalid');
                    return;
                }
                getUrlMetaData(urlInput.value);
            }

            /**
             * Calls the backend to scrape the provided link
             * @param url
             */
            function getUrlMetaData(url){
                let scrapeRoute = SCRAPEROUTE.replace(':url', encodeURIComponent(url));
                console.log(scrapeRoute);

                generatePreviewButton.disabled = true;
                previewButtonReady.classList.add('d-none');
                previewButtonLoading.classList.remove('d-none');

                fetch(scrapeRoute)
                    .then(response => response.json())
                    .then(json => {
                        console.log('parsed json' , json);
                        generatePreviewButton.disabled = false;

                        previewButtonLoading.classList.add('d-none');
                        previewButtonReady.classList.remove('d-none');

                        generateFacebookPreview(json['openGraph']);
                        generateTwitterPreview(json['twitterCard']);

                        if ((validateTags(requiredTwitterTags, json['twitterCard']).length === 0) && validateTags(requiredFacebookTags, json['openGraph']).length === 0){
                            createMessageButton.disabled = false;
                        } else {
                            createMessageButton.disabled = true;
                        }
                    })
            }

            const requiredFacebookTags = ['og:title', 'og:description', 'og:image', 'og:site_name'];
            const requiredTwitterTags = ['twitter:title', 'twitter:description', 'twitter:image', 'twitter:site'];

            /**
             * Checks if tags are valid
             * @param requiredTags
             * @param tags
             * @returns [] array of missing tags
             */
            function validateTags(requiredTags, tags){
                let missingTags = [];

                for( let i = 0; i < requiredTags.length; ++i){
                    if(!tags.hasOwnProperty(requiredTags[i]))
                        missingTags.push(requiredTags[i]);
                }

                return missingTags;
            }

            let facebookPreviewCard = document.getElementById('facebookPreviewCard');
            let invalidFacebookParameters = document.getElementById('invalidFacebookParameters');

            /**
             * Shows missing facebook tags to the user
             * @param missingTags
             */
            function showMissingFacebookTags(missingTags){
                invalidFacebookParameters.innerHTML = "A preview could not be generated because the following information could not be extracted from the link: " + missingTags.join(',');

                facebookPreviewCard.classList.add('d-none');
                invalidFacebookParameters.classList.remove('d-none');
            }

            /**
             * Shows a facebook preview if all tags are valid
             * @param tags
             */
            function generateFacebookPreview(tags){
                let missingTags = validateTags(requiredFacebookTags, tags);
                if (missingTags.length > 0){
                    showMissingFacebookTags(missingTags);
                    return;
                }

                let og_image = document.getElementById('og_image');
                let og_title = document.getElementById('og_title');
                let og_description = document.getElementById('og_description');
                let og_site_name = document.getElementById('og_site_name');

                // Fill in the the card
                og_image.src = tags['og:image'];
                og_title.innerHTML = tags['og:title'];
                og_description.innerHTML = (tags['og:description'].count > 300) ? tags['og:description'].substring(0, 297) + "..." : tags['og:description'];
                og_site_name.innerHTML = tags['og:site_name'].toUpperCase();

                invalidFacebookParameters.classList.add('d-none');
                facebookPreviewCard.classList.remove('d-none');
                console.log('openGraph', tags);
            }

            let twitterPreviewCard = document.getElementById('twitterPreviewCard');
            let invalidTwitterParameters = document.getElementById('invalidTwitterParameters');

            /**
             * Shows missing Twitter tags to the user
             * @param missingTags
             */
            function showMissingTwitterTags(missingTags){
                invalidTwitterParameters.innerHTML = "A preview could not be generated because the following information could not be extracted from the link: " + missingTags.join(',');

                twitterPreviewCard.classList.add('d-none');
                invalidTwitterParameters.classList.remove('d-none');
            }

            /**
             * Shows a Twitter card preview if all tags are valid
             * @param tags
             */
            function generateTwitterPreview(tags){
                let missingTags = validateTags(requiredTwitterTags, tags);
                if (missingTags.length > 0) {
                    showMissingTwitterTags(missingTags);
                    return;
                }

                let twitterImage = document.getElementById('twitter_image');
                let twitterTitle = document.getElementById('twitter_title');
                let twitterDescription = document.getElementById('twitter_description');
                let twitterUrl = document.getElementById('twitter_site');

                // Fill in the card
                twitterImage.src = tags['twitter:image'];
                twitterTitle.innerHTML = tags['twitter:title'];
                twitterDescription.innerHTML = (tags['twitter:description'].count > 160) ? tags['twitter:description'].substring(0, 160) : tags['twitter:description'];
                twitterUrl.innerHTML = tags['twitter:site'];

                twitterPreviewCard.classList.remove('d-none');
                invalidTwitterParameters.classList.add('d-none');
                console.log('twitter tags', tags);
            }

        </script>
    @endpush
</x-app-layout>
