<?php
/*
Template Name: Main
*/

get_header(); ?>

<div class="main-wrapper">
    <div class="button-wrapper">
		<a href="#" class='button-tournament open-modal' data-modal="#start">Start&nbsp;tournament</a>
    </div>
    <div class='modal-start' id='start'>
        <div class='content'>
            <h2 class='title'>Start new tournament</h2>

            <div class="start-content" id="name">
                <p>Enter name of tournament:</p>
                <input class="fm-input" name="tournament-name" type="text" maxlength="64" required>
            </div>

            <div class="start-content" id="players">
                <p>Choose players:</p>
                <div class="players-view"></div>
                <div class="random-player-block"></div>
                <div class="action-buttons">
                    <button class="custom-button btn btn-success new-player-button">+</button>
                    <button class="custom-button btn btn-danger del-player-button">-</button>
                </div>
                <div class="add-player-wrapper invisible">
                    <input class="fm-input" name="player-name" type="text">
                    <button class="btn btn-light add-player">add</button>
                </div>
                <hr>
                <div class="chosen-players-view">
                    <ol>
                    </ol>
				</div>
            </div>

            <div class="start-content" id="teams">
                <p>Choose teams for
                    <input type="number" class="baskets-number" value="1" min="1" max="10">
                    basket:
                </p>
                <button class="back-to-leagues deactivated">back</button>
                <div class="leagues-view"></div>
                <div class="teams-view deactivated"></div>
                <hr>
                <div class="chosen-teams-view"></div>
            </div>

            <div class="start-content" id="teams-to-players">
                <span>Choose team from</span>
                <span class="current-basket-id"></span>
                <span>basket:</span>
                <div class="teams-in-basket-view"></div>
                <div class="random-team-block"></div>
                <div>
                    <span class="manage-baskets previous-basket"><</span><span class="manage-baskets btn-baskets-text">baskets</span><span class="manage-baskets next-basket">></span>
                </div>
                <hr>
                <div class="teams-to-players-view"></div>
            </div>

			<div class="next-button-block">
				<button class="btn btn-dark next-button">
					Next
				</button>
			</div>
        </div>
    </div>
</div>

<?php 
get_footer();