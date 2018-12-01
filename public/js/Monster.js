(function () {
    addEventListener('load', function () {
        let attr = document.getElementById('attr'),
            addAttr = document.getElementById('addAttr'),
            attrSelector = document.getElementById('Attributes');
        addAttr.addEventListener('click', function () {
            let lab = document.createElement('label'),
                hid = document.createElement('input');
            hid.type = 'hidden';
            lab.dataset['text'] = attrSelector.selectedOptions[0].innerText;
            hid.value = attrSelector.value;
            hid.name = 'attributes[]';
            lab.className = 'attrField';
            lab.append(hid);
            lab.addEventListener('click', function () {
                this.remove();
            });
            for (let i of attr.children) {
                if (i.children[0].value === hid.value) {
                    return;
                }
            }
            attr.append(lab);
        });

        let preImg = document.getElementById('preImg'),
            img = document.getElementById('Image'),
            tempFiles = null;
        img.addEventListener('change', function () {
            removePreImage();
            if (this.files.length) {
                let w = 0;
                for (let i of this.files) {
                    if (i.type.startsWith('image')) {
                        let pre = new Image();
                        pre.src = URL.createObjectURL(i);
                        preImg.append(pre);
                        w = pre.width;
                    }
                }
                w = Math.ceil(preImg.offsetWidth / w);
                for (let i = 0; i < w; i++) {
                    let empty = document.createElement('div');
                    empty.className = 'empty';
                    preImg.append(empty);
                }
                tempFiles = this.files;
            } else {
                this.files = tempFiles;
            }
        });

        function removePreImage() {
            preImg.querySelectorAll('img').forEach(a => {
                if (a.src.startsWith('blob')) {
                    URL.revokeObjectURL(a.src);
                }
                a.remove();
            });
            preImg.innerHTML = "";
        }

        let createBtn = document.getElementById('createMonster');
        if (createBtn) {
            createBtn.addEventListener('click', function () {
                let f = new FormData(this.form);
                console.dir(this);
            });
        }
    });
})();
