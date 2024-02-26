import Resumable from "resumablejs";
import convert from "../../utils/converter";
import decoder from "../../utils/decoder";
import { ResumableMessageT } from "../../types";
export function videoUpload(name :string) {
    const uploadRouteElm = document.querySelector<HTMLInputElement>(
        `#${name}-upload-route`,
    );
    const submitButton = document.querySelector<HTMLButtonElement>(
        `#video-submit-button`,
    );
    const fileUpload =
        document.querySelector<HTMLButtonElement>(`#${name}-resumable-browse`);
    const fileUploadDrop = document.querySelector(`#${name}-resumable-drop`);
    const token =
        document.querySelector<HTMLInputElement>("input[name=_token]");
    const videoPreview = document.getElementById(`${name}Preview`);
    const form = document.querySelector<HTMLFormElement>(`#${name}-form`);
    console.log(uploadRouteElm,
        submitButton,
        fileUpload,
        fileUploadDrop,
        token ,
        videoPreview,
        form);
    if (
        uploadRouteElm &&
        submitButton &&
        fileUpload &&
        fileUploadDrop &&
        token &&
        videoPreview &&
        form
    ) {
        const chunkSize = 5 * 1024 * 1024; // 5MB
        const r = new Resumable({
            chunkSize: chunkSize,
            target: uploadRouteElm.value,
            query: { _token: token.value },
        });
        if (!r.support) {
            console.error("resumable support error");
        } else {
            r.assignDrop(fileUpload);
            r.assignBrowse(fileUploadDrop, false);

            r.on("fileAdded", function (file: Resumable.ResumableFile) {
                submitButton.disabled = true;
                r.upload();

                videoPreview.innerHTML = `<div id="${name}-progress-container" class="flex flex-col justify-center items-center">
                <p class="mb-2">動画アップロード中</p>
                <div class="w-full overflow-hidden rounded-1 border" style="height: 0.5rem">
                    <div id="${name}-progress" class="bg-primary-400 h-full" style="width: 10%"></div>
                </div>
            </div>`;
            });
            r.on(
                "fileSuccess",
                function (file: Resumable.ResumableFile, message: string) {
                    const res = convert.only(
                        decoder.only(JSON.parse(message), ResumableMessageT),
                        true,
                    );
                    if (!res) {
                        return;
                    }
                    const videoPath =
                        document.querySelector<HTMLInputElement>("#video_path");
                    if (videoPath) {
                        videoPath.value = `${res.path}${res.name}`;
                    }
                    console.log(res);
                    videoPreview.innerHTML = `<video id="${name}-video-js" class="video video-js" playsinline controls><source src="/storage/videos/${res.path}${res.name}"></video>`;
                    submitButton.disabled = false;
                    form.value = res.full_path;
                },
            );
            r.on(
                "fileError",
                function (file: Resumable.ResumableFile, message) {
                    console.error(message);
                    videoPreview.innerHTML = `<div class="flex justify-center items-center">
                    <p style="width: auto; height: auto" class="m-0 static">エラーが発生しました</p>
                </div>`;
                },
            );
            r.on("fileProgress", function (file: Resumable.ResumableFile) {
                const progress = file.progress(true);
                const progressBar =
                    document.querySelector<HTMLDivElement>(`#${name}-progress`);
                if (progressBar) {
                    progressBar.style.width = `${progress * 100}%`;
                }
            });
        }
    } else {
        console.log("error");
    }
}
