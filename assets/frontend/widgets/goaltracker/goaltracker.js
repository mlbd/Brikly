(function ($) {
    function initLottieInScope(scope) {
        const $containers = $(scope).find('.goal-tracker-lottie');

        $containers.each(function () {
            const $container = $(this);

            // Prevent duplicate players
            if ($container.find('lottie-player').length > 0) return;

            const url = $container.data('lottie-url');
            const type = $container.data('animation-type'); // once / loop
            const direction = $container.data('animation-direction');
            const trigger = $container.data('trigger-event') || 'view';
            const repeater = $container.data('event-repeater') === 'yes';

            if (!url) return;

            const $player = $('<lottie-player>', {
                src: url,
                background: 'transparent',
                speed: '1',
                style: 'width:100%;height:100%',
                autoplay: false,
            });

            if (type === 'loop') $player.attr('loop', '');
            if (direction === 'reverse') $player.attr('direction', '-1');

            $container.append($player);
            const playerEl = $player[0];

            const playIfNotAlreadyPlaying = async () => {
                if (!playerEl.getLottie) return;
                const lottie = await playerEl.getLottie();
                const isPlaying = !lottie.isPaused && lottie.currentFrame > 0 && lottie.currentFrame < lottie.totalFrames;

                if (!isPlaying) {
                    playerEl.stop();
                    playerEl.play();
                }
            };

            // Trigger logic
            switch (trigger) {
                case 'view':
                    const observer = new IntersectionObserver(entries => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                if (type === 'once') {
                                    if (repeater) {
                                        // Replay animation each time widget is in view
                                        playIfNotAlreadyPlaying();
                                    } else {
                                        // Play once then disconnect observer
                                        playerEl.play();
                                        observer.disconnect();
                                    }
                                } else {
                                    playerEl.play();
                                }
                            }
                        });
                    });
                    observer.observe($container[0]);
                    break;

                case 'hover':
                    $container.on('mouseenter', async () => {
                        if (type === 'once' && repeater) {
                            await playIfNotAlreadyPlaying();
                        } else {
                            playerEl.play();
                        }
                    });
                    break;

                case 'click':
                    $container.on('click', async () => {
                        if (type === 'once' && repeater) {
                            await playIfNotAlreadyPlaying();
                        } else {
                            playerEl.play();
                        }
                    });
                    break;

                default:
                    playerEl.play();
            }
        });
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/brikly_goal_tracker.default',
            function ($scope) {
                const targetNode = $scope[0];

                const deepCheck = () => {
                    const $lottie = $($scope).find('.goal-tracker-lottie');
                    if ($lottie.length > 0) {
                        initLottieInScope($scope);
                        return true;
                    }
                    return false;
                };

                if (deepCheck()) return;

                const observer = new MutationObserver((mutations, obs) => {
                    if (deepCheck()) {
                        obs.disconnect();
                    }
                });

                observer.observe(targetNode, {
                    childList: true,
                    subtree: true,
                });
            }
        );
    });

    $(document).ready(function () {
        initLottieInScope(document);
    });
})(jQuery);
