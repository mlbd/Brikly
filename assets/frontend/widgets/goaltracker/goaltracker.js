(function ($) {
    function initLottieInScope(scope) {
        const $containers = $(scope).find('.goal-tracker-lottie');

        $containers.each(function () {
            const $container = $(this);

            // Prevent duplicate players
            if ($container.find('lottie-player').length > 0) return;

            const url = $container.data('lottie-url');
            const type = $container.data('animation-type'); // 'once' or 'loop'
            const direction = $container.data('animation-direction'); // 'forward' or 'reverse'
            const trigger = $container.data('trigger-event') || 'view'; // 'click', 'hover', or 'view'
            const repeater = $container.data('event-repeater') === 'yes';

            const targetOption = $container.data('trigger-target') || 'default';
            const customSelector = $container.data('custom-selector') || '';

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

            // Determine the target element based on selection
            let $targetEl;
            switch (targetOption) {
                case 'section':
                    $targetEl = $container.closest('.elementor-section');
                    break;
                case 'column':
                    $targetEl = $container.closest('.elementor-column');
                    break;
                case 'custom':
                    $targetEl = $(customSelector);
                    break;
                case 'widget':
                    $targetEl = $container.closest('.elementor-widget');
                    break;
                default:
                    $targetEl = $container;
                    break;
            }

            // Fallback if target not found
            if ($targetEl.length === 0) $targetEl = $container;

            // Trigger logic
            switch (trigger) {
                case 'view':
                    let wasVisible = false;

                    const observer = new IntersectionObserver(entries => {
                        entries.forEach(async entry => {
                            const isVisibleNow = entry.isIntersecting;

                            if (isVisibleNow && !wasVisible) {
                                wasVisible = true;

                                console.log('Widget is now visible:', $container[0]);

                                // Reset animation and play again
                                try {
                                    const lottie = await playerEl.getLottie();
                                    lottie.stop();
                                    lottie.play();
                                } catch (e) {
                                    // fallback if getLottie is not available
                                    playerEl.stop();
                                    playerEl.play();
                                }

                            } else if (!isVisibleNow && wasVisible) {
                                wasVisible = false;
                                console.log('Widget is now hidden:', $container[0]);
                            }
                        });
                    }, {
                        threshold: 0.5, // Adjust if needed
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
        elementorFrontend.hooks.addAction('frontend/element_ready/brikly_goal_tracker.default', initLottieInScope);
    });
})(jQuery);
