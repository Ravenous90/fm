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
                <input class="fm-input" name="tournament-name" type="text" required>
            </div>

            <div class="start-content" id="players">
                <p>Choose players:</p>
                <div class="players-view"></div>
					<input class="fm-input" name="player-name" type="text">
					<button class="btn btn-light add-player">Add</button>
                <hr>
                <div class="chosen-players-view">
                    <ol>
                    </ol>
				</div>
				
            </div>

            <div class="start-content" id="teams">
                <span>step3</span>
            </div>

			<div class="next-button-block">
				<button class="btn btn-dark next-button">
					Next
				</button>
			</div>
        </div>
    </div>

	<div style="width: 100%; background: #FFFFFF;">
            <div id="get-all-info">
                GET INFO
            </div>
	</div>
</>

<?php 
get_footer();