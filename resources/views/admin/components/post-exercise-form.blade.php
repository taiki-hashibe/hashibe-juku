<div x-data='{
    exercises: [],
    process: 0,
    uniqueId() {
        this.process++;
        return this.process + Math.random().toString(36).substr(2,
            9);
    },
    addExercise() {
        this.exercises.push({
            id: this.uniqueId(),
            question: "",
            choices: [{
                id: this.uniqueId(),
                text: "",
                is_correct: false,
            }],
        });
    },
    addExerciseChoice(exercise_index) {
        this.exercises[exercise_index].choices.push({ id: this.uniqueId(), text: "", is_correct: false});
    },
    removeExerciseChoice(exercise_index, choice_index) {
        this.exercises[exercise_index].choices.splice(choice_index, 1);
    },
}'
    x-init="exercises = {{ old('exercises') ? Illuminate\Support\Js::from(old('exercises')) : Illuminate\Support\Js::from($post->exercises()->mapping()) }} ?? [];
    console.log(exercises)
    const errors = {{ Illuminate\Support\Js::from($errors->get('exercises.*')) }};
    exercises.forEach((exercise, exercise_index) => {
        const indexKey = 'exercises.' + exercise_index + '.question';
        if (errors[indexKey]) {
            if (!exercises[exercise_index].errors) {
                exercises[exercise_index].errors = [];
            }
            exercises[exercise_index].errors.push(errors[indexKey])
        }
        const choiceIndexKey = 'exercises.' + exercise_index + '.choices';
        if (errors[choiceIndexKey]) {
            if (!exercises[exercise_index].errors) {
                exercises[exercise_index].errors = [];
            }
            exercises[exercise_index].errors.push(errors[choiceIndexKey])
        }
        exercise.choices.forEach((choice, choice_index) => {
            const indexKey = 'exercises.' + exercise_index + '.choices.' + choice_index + '.text';
            if (errors[indexKey]) {
                if (!exercises[exercise_index].choices[choice_index].errors) {
                    exercises[exercise_index].choices[choice_index].errors = [];
                }
                exercises[exercise_index].choices[choice_index].errors.push(errors[indexKey])
            }
        });
    });
    console.log(exercises)">
    <template x-for="(exercise, exercise_index) in exercises" :key="exercise.id">
        <div class="mb-6">
            <div class="flex justify-between mb-2">
                <h3 class="text-sm" x-text="'問題' + (exercise_index + 1)">
                </h3>
                <button type="button" @click="exercises.splice(exercise_index, 1)"
                    class="cursor-pointer p-1 rounded-full bg-red-400 text-white flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mb-2">
                <input type="hidden" x-bind:name="'exercises[' + exercise_index + '][id]'" :value="exercise.id">
                <input
                    class="w-full inline-block rounded-md border duration-100 focus:outline-0 focus:border-purple-500 px-3 py-2"
                    x-bind:class="{ 'border-red-500': exercise.errors }" placeholder="問題文"
                    x-bind:name="'exercises[' + exercise_index + '][question]'" :value="exercise.question">
                <template x-if="exercise.errors">
                    <template x-for="error in exercise.errors">
                        <p class="text-red-500 text-xs mt-1" x-text="error"></p>
                    </template>
                </template>
            </div>
            <div class="mb-4">
                <template x-for="(choice, choice_index) in exercise.choices" :key="exercise.id + '-' + choice.id">
                    <div class="relative flex items-center mb-2">
                        <input type="hidden"
                            x-bind:name="'exercises[' + exercise_index + '][choices][' + choice_index +
                                '][id]'"
                            :value="choice.id">
                        <input type="checkbox"
                            x-bind:name="'exercises[' + exercise_index + '][choices][' + choice_index +
                                '][is_correct]'"
                            class="inline me-2" :checked="choice.is_correct">
                        <input
                            class="w-full inline-block rounded-md border duration-100 focus:outline-0 focus:border-purple-500 px-3 py-2"
                            x-bind:class="{ 'border-red-500': choice.errors }" placeholder="選択肢"
                            x-bind:name="'exercises[' + exercise_index + '][choices][' + choice_index + '][text]'"
                            :value="choice.text">
                        <button type="button" @click="removeExerciseChoice(exercise_index, choice_index)"
                            class="absolute right-1 cursor-pointer rounded-full p-1 text-slate-600 duration-100 hover:bg-slate-300 hover:text-white flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <template x-if="choice.errors">
                        {{-- :TODO --}}
                        <template x-for="choice_error in choice.errors">
                            <p class="text-red-500 text-xs mt-1" x-text="choice_error"></p>
                        </template>
                    </template>
                </template>
                <button type="button" @click="addExerciseChoice(exercise_index)"
                    class="w-full flex justify-center items-center mb-2 relative hover:text-purple-500">
                    <input type="checkbox" disabled class="inline me-2">
                    <input disabled
                        class="w-full inline-block rounded-md border duration-100 focus:outline-0 focus:border-purple-500 px-3 py-2">
                    <div class="absolute w-full h-full flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-3 h-3 duration-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                </button>
            </div>
        </div>
    </template>
    <div>
        <button type="button" @click="addExercise()"
            class="cursor-pointer w-full mb-4 block px-3 py-2 border border-slate-300 rounded-md text-start flex flex-col justify-center items-center py-4 text-slate-600 hover:text-purple-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 duration-100">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </button>
    </div>
</div>
