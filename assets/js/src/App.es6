import Step from './Step.es6';

class App {
    constructor() {
        this.currentStep = null;
    }

    /**
     * Starts the App.
     */
    run() {
        this.currentStep = Step.retrieveLoadedStep();
    }
}

export default App;