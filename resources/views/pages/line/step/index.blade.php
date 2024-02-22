<x-guest-layout class="bg-white" unlink>
    <div>
        コンテンツ
    </div>
    <div>
        <form action="" method="post"></form>
    </div>
    <script>
        const getLiffLocalStorageKeys = (prefix) => {
            const keys = []
            for (var i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i)
                if (key && key.indexOf(prefix) === 0) {
                    keys.push(key);
                }
            }
            return keys
        }
        const clearExpiredIdToken = (liffId) => {
            const keyPrefix = `LIFF_STORE:${liffId}:`
            const key = keyPrefix + 'decodedIDToken'
            const decodedIDTokenString = localStorage.getItem(key)
            if (!decodedIDTokenString) {
                return
            }
            const decodedIDToken = JSON.parse(decodedIDTokenString)
            if (new Date().getTime() > decodedIDToken.exp * 1000) {
                const keys = getLiffLocalStorageKeys(keyPrefix)
                keys.forEach(function(key) {
                    localStorage.removeItem(key)
                })
            }
        }
        clearExpiredIdToken('{{ config('line.liff.step_id') }}');
        liff.init({
            liffId: '{{ config('line.liff.step_id') }}',
            withLoginOnExternalBrowser: true,
        }).then(() => {
            const _token = liff.getIDToken();
            alert(_token);
            axios.post('{{ route('line.step.get-profile') }}', {
                id_token: _token,
                _token: "{{ csrf_token() }}"
            }).then((r) => {
                if (r.data.status === 302) {} else {

                }
                alert(r.data.status);
            });
        }).catch((e) => {
            alert(e);
        });
    </script>
</x-guest-layout>
