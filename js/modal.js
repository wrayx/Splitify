export default class Modal {
    constructor(type, id) {
        this._type = type;
        this._id = id;
    }

    // get type() {
    //     return this._type;
    // }
    //
    // get id() {
    //     return this._id;
    // }

    static getModalId(modalsOnPage) {
        return modalsOnPage.split('-').pop();
    }

    htmlModalId() {
        return `${this._type}-modal-${this._id}`;
    }

    htmlTriggerId() {
        return `${this._type}-modal-trigger-${this._id}`;
    }

    htmlCancelId() {
        return `${this._type}-modal-cancel-${this._id}`;
    }

    htmlCloseId() {
        return `${this._type}-modal-close-${this._id}`;
    }

    htmlProceedId() {
        return `${this._type}-modal-proceed-${this._id}`;
    }

    addModalEvtListener() {
        let trigger = document.querySelector(`#${this.htmlTriggerId()}`);
        let cancel = document.querySelector(`#${this.htmlCancelId()}`);
        let close = document.querySelector(`#${this.htmlCloseId()}`);

        trigger.addEventListener("click", () => {
            this.openModal();
        });
        cancel.addEventListener("click", () => {
            this.closeModal();
        });
        close.addEventListener("click", () => {
            this.closeModal();
        });
    }

    openModal() {
        let modal = document.querySelector(`#${this.htmlModalId()}`);
        modal.style.display = "block";
    }

    closeModal() {
        let modal = document.querySelector(`#${this.htmlModalId()}`);
        modal.style.display = "none";
    }
}